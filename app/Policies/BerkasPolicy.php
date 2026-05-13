<?php

namespace App\Policies;

use App\Models\User;
use App\Models\BerkasFolder;
use App\Models\BerkasFile;
use Illuminate\Auth\Access\HandlesAuthorization;

class BerkasPolicy
{
    use HandlesAuthorization;

    /**
     * Admin has full access to everything.
     */
    public function before(User $user, $ability)
    {
        if ($user->role === 'admin') {
            return true;
        }
    }

    /**
     * Determine whether the user can view the folder.
     */
    public function viewFolder(User $user, BerkasFolder $folder)
    {
        // Owner can view
        if ($user->id === $folder->user_id) {
            return true;
        }

        // Shared with specific user
        $hasUserShare = $folder->shares()->where('shared_with_user_id', $user->id)->exists();
        if ($hasUserShare) return true;

        // Shared with user's role
        $hasRoleShare = $folder->shares()->where('shared_with_role', $user->role)->exists();
        if ($hasRoleShare) return true;

        return false;
    }

    /**
     * Determine whether the user can view the file.
     */
    public function viewFile(User $user, BerkasFile $file)
    {
        // Owner can view
        if ($user->id === $file->user_id) {
            return true;
        }

        // Shared specifically
        $hasUserShare = $file->shares()->where('shared_with_user_id', $user->id)->exists();
        if ($hasUserShare) return true;

        // Shared with role
        $hasRoleShare = $file->shares()->where('shared_with_role', $user->role)->exists();
        if ($hasRoleShare) return true;

        // Or if the parent folder is shared, user can also view the file inside it
        if ($file->folder && $this->viewFolder($user, $file->folder)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can modify the folder.
     */
    public function modifyFolder(User $user, BerkasFolder $folder)
    {
        // Only owner (or admin via before()) can modify/delete for now
        return $user->id === $folder->user_id;
    }

    /**
     * Determine whether the user can modify the file.
     */
    public function modifyFile(User $user, BerkasFile $file)
    {
        // Only owner (or admin) can modify/delete for now
        return $user->id === $file->user_id;
    }
}
