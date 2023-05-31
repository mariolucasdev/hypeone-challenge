<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageStoreRequest;
use App\Models\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    /**
     * Get chat messages
     *
     * @param string $chatId
     * @return JsonResponse
     */
    public function index(string $chatId): JsonResponse
    {
        $messages = Message::where('chat_id', $chatId)->get();
        return response()->json($messages, 200);
    }

    /**
     * Store messages on database
     *
     * @param MessageStoreRequest $request
     * @return JsonResponse
     */
    public function store(MessageStoreRequest $request): JsonResponse
    {
        $validated = Validator::make($request->all(), $request->rules());

        $message = Message::create($request->all());

        return response()->json($message, 201);
    }
}
