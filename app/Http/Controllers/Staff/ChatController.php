<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Services\ChatService;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function __construct(private ChatService $chatService) {}

    public function index(Request $request)
    {
        return view('staff.chats.index', $this->chatService->getIndexData(auth()->user(), 'staff'));
    }

    public function getStudents(Request $request)
    {
        return response()->json($this->chatService->getStudentsResponse($request->cohort, 'staff'));
    }

    public function show($id)
    {
        $data = $this->chatService->getShowData(auth()->user(), $id, 'staff');
        if (request()->ajax()) {
            return response()->json(['chats' => $data['chats']]);
        }
        return view('staff.chats.show', $data);
    }

    public function store(Request $request, $id)
    {
        $request->validate($this->chatService->messageRules('staff'));

        $chat = $this->chatService->sendMessage(auth()->user(), $id, $request->all(), $request->file('file'));

        if ($request->ajax()) {
            return response()->json(['success' => true, 'chat' => $chat, 'time' => $chat->created_at->format('H:i')]);
        }

        return redirect()->route($this->chatService->redirectRoute('staff'), $id);
    }
}
