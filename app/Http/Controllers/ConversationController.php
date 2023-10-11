<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Events\NewMessage;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    public function store(Request $request) {
        $conversation = Conversation::create([
            "username" => $request->username,
            "message" => $request->message,
            "channel" => $request->channel
        ]);

        broadcast(new NewMessage($conversation));
    }
}
