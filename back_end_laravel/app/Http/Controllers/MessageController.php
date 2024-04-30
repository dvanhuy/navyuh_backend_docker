<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $user = new User();
        $user = $user->getUserFromToken($request);
        $check = Message::create([
            'content' => $request['message'],
            'sender_id'=>$user->id,
            'server_id'=>$request['server_id']
        ]);
        broadcast(new MessageSent($user,$request['message']));
        return response($user->id);
    }
}
