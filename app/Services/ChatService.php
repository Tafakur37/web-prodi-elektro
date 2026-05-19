<?php

namespace App\Services;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class ChatService
{
    /**
     * Data untuk halaman index chat berdasarkan konteks role fitur.
     */
    public function getIndexData(User $user, string $contextRole): array
    {
        return match ($contextRole) {
            'mahasiswa' => [
                'dosens' => $this->getDosens(),
            ],
            'dosen' => [
                'cohorts' => $this->getCohorts(),
                'recentContacts' => $this->getRecentContacts($user),
            ],
            'staff' => [
                'cohorts' => $this->getCohorts(),
                'recentChatUsers' => $this->getRecentContacts($user),
            ],
            default => [
                'recentContacts' => $this->getRecentContacts($user),
            ],
        };
    }

    /**
     * Data untuk halaman percakapan berdasarkan konteks role fitur.
     */
    public function getShowData(User $user, int $partnerId, string $contextRole): array
    {
        $partner = User::findOrFail($partnerId);
        $this->markAsRead($partnerId, $user->id);

        $data = [
            'chats' => $this->getConversation($user->id, $partnerId),
        ];

        return match ($contextRole) {
            'staff' => $data + [
                'student' => $partner,
            ],
            'dosen' => $data + [
                'mahasiswa' => $partner,
                'cohorts' => $this->getCohorts(),
            ],
            'mahasiswa' => $data + [
                'dosen' => $partner,
                'dosens' => $this->getDosens(),
            ],
            default => $data + [
                'partner' => $partner,
            ],
        };
    }

    /**
     * Format response mahasiswa berdasarkan konteks role fitur.
     */
    public function getStudentsResponse(?string $cohort, string $contextRole): array
    {
        $students = $cohort ? $this->getStudentsByCohort($cohort) : collect();

        return $contextRole === 'staff'
            ? $students->values()->all()
            : ['students' => $students];
    }

    /**
     * Aturan validasi kirim chat berdasarkan konteks role fitur.
     */
    public function messageRules(string $contextRole): array
    {
        if ($contextRole === 'staff') {
            return [
                'message' => 'required|string',
            ];
        }

        return [
            'message' => 'required_without:file|string|nullable',
            'file' => 'nullable|file|max:5120',
        ];
    }

    /**
     * Route tujuan setelah mengirim pesan.
     */
    public function redirectRoute(string $contextRole): string
    {
        return match ($contextRole) {
            'staff' => 'staff.chats.show',
            'dosen' => 'dosen.chats.show',
            'mahasiswa' => 'mahasiswa.chats.show',
            default => 'home',
        };
    }

    /**
     * Ambil daftar cohort unik dari mahasiswa.
     */
    public function getCohorts()
    {
        return User::where('role', 'mahasiswa')
            ->whereNotNull('cohort')
            ->distinct()
            ->pluck('cohort')
            ->filter();
    }

    /**
     * Ambil daftar mahasiswa berdasarkan cohort.
     */
    public function getStudentsByCohort(string $cohort)
    {
        return User::where('role', 'mahasiswa')
            ->where('cohort', $cohort)
            ->select('id', 'name', 'nim', 'profile_photo')
            ->get();
    }

    /**
     * Ambil daftar kontak yang pernah berinteraksi chat dengan user.
     */
    public function getRecentContacts(User $user)
    {
        $contactIds = Chat::where('sender_id', $user->id)
            ->pluck('receiver_id')
            ->concat(Chat::where('receiver_id', $user->id)->pluck('sender_id'))
            ->unique()
            ->toArray();

        return User::whereIn('id', $contactIds)->get();
    }

    /**
     * Ambil daftar dosen (untuk mahasiswa memilih lawan chat).
     */
    public function getDosens()
    {
        return User::where('role', 'dosen')->get();
    }

    public function getConversation(int $userId, int $partnerId)
    {
        $chats = Chat::where(function ($q) use ($userId, $partnerId) {
            $q->where('sender_id', $userId)->where('receiver_id', $partnerId);
        })->orWhere(function ($q) use ($userId, $partnerId) {
            $q->where('sender_id', $partnerId)->where('receiver_id', $userId);
        })->orderBy('created_at', 'asc')->get();

        return $chats->filter(function ($chat) use ($userId) {
            if ($chat->sender_id === $userId && $chat->deleted_by_sender) {
                return false;
            }
            if ($chat->receiver_id === $userId && $chat->deleted_by_receiver) {
                return false;
            }
            return true;
        })->map(function ($chat) {
            if ($chat->is_deleted_for_everyone) {
                $chat->message = '🚫 Pesan ini telah dihapus';
                $chat->file_path = null;
            }
            return $chat;
        })->values();
    }

    /**
     * Hapus pesan chat.
     */
    public function deleteMessage(int $messageId, int $userId, string $type)
    {
        $chat = Chat::findOrFail($messageId);

        if ($type === 'for_everyone' && $chat->sender_id === $userId) {
            $chat->update(['is_deleted_for_everyone' => true]);
            return true;
        }

        if ($type === 'for_me') {
            if ($chat->sender_id === $userId) {
                $chat->update(['deleted_by_sender' => true]);
            } elseif ($chat->receiver_id === $userId) {
                $chat->update(['deleted_by_receiver' => true]);
            }
            return true;
        }

        return false;
    }

    /**
     * Tandai semua pesan dari sender ke receiver sebagai sudah dibaca.
     */
    public function markAsRead(int $senderId, int $receiverId): void
    {
        Chat::where('sender_id', $senderId)
            ->where('receiver_id', $receiverId)
            ->where('is_read', false)
            ->update(['is_read' => true]);
    }

    /**
     * Kirim pesan chat, termasuk upload file, broadcast, dan notifikasi.
     */
    public function sendMessage(User $sender, int $receiverId, array $data, ?UploadedFile $file = null): Chat
    {
        $filePath = null;
        if ($file) {
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/chats', $filename);
            $filePath = $filename;
        }

        $chat = Chat::create([
            'sender_id'   => $sender->id,
            'receiver_id' => $receiverId,
            'message'     => $data['message'] ?? '',
            'file_path'   => $filePath,
            'is_read'     => false,
        ]);

        $receiver = User::findOrFail($receiverId);

        // Broadcast event real-time
        if (class_exists(\App\Events\MessageSent::class)) {
            try {
                broadcast(new \App\Events\MessageSent($chat))->toOthers();
            } catch (\Exception $e) {
                Log::warning('Broadcast failed: ' . $e->getMessage());
            }
        }

        // Kirim notifikasi ke penerima
        $this->sendChatNotification($sender, $receiver);

        return $chat;
    }

    /**
     * Kirim notifikasi chat ke penerima berdasarkan role.
     */
    private function sendChatNotification(User $sender, User $receiver): void
    {
        $roleLabel = match ($sender->role) {
            'dosen'     => 'Dosen',
            'mahasiswa' => 'Mahasiswa',
            'staff'     => 'Staff',
            'admin'     => 'Admin',
            default     => 'User',
        };

        // Tentukan URL notifikasi berdasarkan role penerima
        $url = '#';
        if ($receiver->role === 'mahasiswa') {
            $url = route('mahasiswa.chats.show', $sender->id);
        } elseif ($receiver->role === 'dosen') {
            $url = route('dosen.chats.show', $sender->id);
        } elseif ($receiver->role === 'staff') {
            $url = route('staff.chats.show', $sender->id);
        }

        $receiver->notify(new \App\Notifications\AppNotification([
            'title'   => "Pesan Baru {$roleLabel}",
            'message' => "Anda menerima pesan baru dari {$sender->name}",
            'url'     => $url,
            'type'    => 'info',
        ]));
    }
}
