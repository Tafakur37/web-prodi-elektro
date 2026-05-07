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
        return view('staff.chats.show', $this->chatService->getShowData(auth()->user(), $id, 'staff'));
    }

    public function store(Request $request, $id)
    {
        $request->validate($this->chatService->messageRules('staff'));

        $this->chatService->sendMessage(auth()->user(), $id, $request->all());

        return redirect()->route($this->chatService->redirectRoute('staff'), $id);
    }
}
