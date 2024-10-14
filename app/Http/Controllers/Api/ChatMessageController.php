<?php

namespace App\Http\Controllers\Api;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChatMessageRequest;
use App\Http\Requests\UpdateChatMessageRequest;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatMessageController extends Controller
{

    /**
     * Display the specified resource.
     */
    public function getMessage(User $user, Request $request)
    {
        $request->validate(['archivados' => 'nullable|boolean']);

        $message = ChatMessage::query()
        ->with(['sender', 'receiver'])
        ->where(function($query) use ($user){
            $query->where('sender_id', Auth::id())
                ->where('receiver_id', $user->id);
        })
        ->orWhere(function($query) use ($user){
            $query->where('sender_id', $user->id)
                ->where('receiver_id', Auth::id());
        })->when($request->filled('archivados'), function ($query) use ($request){
            if ($request->boolean('archivados')){
                $query->onlyTrashed();
            }
        })
        ->orderBy('id', 'asc')
        ->get();

        return response()->json([
            "message" => $message
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function sendMessage(StoreChatMessageRequest $request, User $user)
    {
        $message = ChatMessage::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $user->id,
            'text'  => $request->input('message')
        ]);

        broadcast(new MessageSent($message));

        return response()->json([
            "message" => $message
        ]);
    }

}
