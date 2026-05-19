<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Services\ChatService;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function __construct(private ChatService $chatService) {}

    public function index()
    {
        return view('dosen.chats.index', $this->chatService->getIndexData(auth()->user(), 'dosen'));
    }

    public function getStudents(Request $request)
    {
        return response()->json($this->chatService->getStudentsResponse($request->cohort, 'dosen'));
    }

    public function show($id)
    {
        $data = $this->chatService->getShowData(auth()->user(), $id, 'dosen');
        if (request()->ajax()) {
            return response()->json(['chats' => $data['chats']]);
        }
        return view('dosen.chats.show', $data);
    }

    public function store(Request $request, $id)
    {
        $request->validate($this->chatService->messageRules('dosen'));

        $chat = $this->chatService->sendMessage(
            auth()->user(),
            $id,
            $request->all(),
            $request->file('file')
        );

        if ($request->ajax()) {
            return response()->json(['success' => true, 'chat' => $chat, 'time' => $chat->created_at->format('H:i')]);
        }

        return redirect()->route($this->chatService->redirectRoute('dosen'), $id);
    }

    public function destroy(Request $request, $id)
    {
        $success = $this->chatService->deleteMessage($id, auth()->id(), $request->type);
        return response()->json(['success' => $success]);
    }
}
