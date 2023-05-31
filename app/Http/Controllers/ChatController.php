<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChatStoreRequest;
use App\Models\Chat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
        $validated = $request->validated();

        if ($validated) {

            $chat = Chat::create($request->all());

            return response()->json($chat, 201);
        }

        return response()->json(['error' => 'Não foi possível iniciar o atendimento.'], 500);
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

        $closed = $chat->update(['closed' => true]);

        if ($closed) {
            return response()->json($chat, 200);
        }

        return response()->json(
            [
                'error' => 'Não foi possível finalizar o atendimento.',
                'chat' => $chat
            ],
            500
        );
    }
}
