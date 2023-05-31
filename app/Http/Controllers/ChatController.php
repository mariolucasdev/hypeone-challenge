<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChatStoreRequest;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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

        return response()->json($chat, 201);
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
