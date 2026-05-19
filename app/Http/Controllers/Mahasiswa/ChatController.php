<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Services\ChatService;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function __construct(private ChatService $chatService) {}

    public function index()
    {
        return view('mahasiswa.chats.index', $this->chatService->getIndexData(auth()->user(), 'mahasiswa'));
    }

    public function show($id)
    {
        $data = $this->chatService->getShowData(auth()->user(), $id, 'mahasiswa');
        if (request()->ajax()) {
            return response()->json(['chats' => $data['chats']]);
        }
        return view('mahasiswa.chats.show', $data);
    }

    public function store(Request $request, $id)
    {
        $request->validate($this->chatService->messageRules('mahasiswa'));

        $chat = $this->chatService->sendMessage(
            auth()->user(),
            $id,
            $request->all(),
            $request->file('file')
        );

        if ($request->ajax()) {
            return response()->json(['success' => true, 'chat' => $chat, 'time' => $chat->created_at->format('H:i')]);
        }

        return redirect()->route($this->chatService->redirectRoute('mahasiswa'), $id);
    }

    public function destroy(Request $request, $id)
    {
        $success = $this->chatService->deleteMessage($id, auth()->id(), $request->type);
        return response()->json(['success' => $success]);
    }
}
