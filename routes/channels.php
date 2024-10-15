<?php

use App\Models\ChatMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.{id}', function ($user, $id) {
    $auth = (int) $user->id == (int) $id;
    if ((int) $user->id != (int) $id){
        $chat = ChatMessage::query()
        ->with(['sender', 'receiver'])
        ->where(function($query) use ($user, $id){
            $query->where('sender_id', $user->id)
                ->where('receiver_id', $id);
        })
        ->orWhere(function($query) use ($user, $id){
            $query->where('sender_id', $id)
                ->where('receiver_id', $user->id);
        });

        $auth = $chat ? true : false;
    }
    return $auth;
});
