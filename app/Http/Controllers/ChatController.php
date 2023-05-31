<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChatStoreRequest;
use App\Models\Chat;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function start(ChatStoreRequest $request)
    {
        $validated = $request->validated();

        if ($validated) {
            $chat = Chat::create($request->all());

            return response()->json($chat, 201);
        }

        return response()->json(['error' => 'Não foi possível iniciar o atendimento.'], 500);
    }
}
