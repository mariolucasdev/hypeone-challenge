<?php

namespace App\Http\Controllers;

use App\Events\channelChat;
use App\Http\Requests\ChatStoreRequest;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    /**
     * Start Chat Session
     *
     * @param ChatStoreRequest $request
     * @return JsonResponse
     */
    public function start(ChatStoreRequest $request): JsonResponse
    {
        $validated = Validator::make($request->all(), $request->rules());

        $chat = Chat::create($request->all());

        $request->session()->put([
            'chat_id' => $chat->id,
            'title' => $chat->title,
            'name' => $chat->username
        ]);

        broadcast(new channelChat($chat->title, $chat->username, $chat->id));

        return response()->json($chat, 201);
    }

    /**
     * Get Chat Info
     *'
     * @param string $id
     * @return JsonResponse
     */
    public function details(string $id): JsonResponse
    {
        $chat = Chat::find($id);

        return ($chat) ?
            response()->json($chat, 200) :
            response()->json(['error' => 'Chat não encontrado.'], 404);
    }

    /**
     * Close Chat Session
     *
     * @param string $id
     * @return JsonResponse
     */
    public function close(string $id): JsonResponse
    {
        $chat = Chat::find($id);

        if ($chat) {

            $chat->update(['closed' => true]);

            return response()->json($chat, 200);
        }

        return response()->json(['error' => 'Chat não encontrado.'], 404);
    }
}
