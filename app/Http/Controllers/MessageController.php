<?php

namespace App\Http\Controllers;

use App\Events\channelChat;
use App\Events\ChannelMessage;
use App\Events\SendMessage;
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
    public function index(int $chatId): JsonResponse
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

        broadcast(new SendMessage($message));

        // broadcast(new ChannelMessage($message->chat_id, [
        //     'content' => $message->content,
        //     'username' => $message->username,
        //     'createdAt' => $message->created_at
        // ]));

        return response()->json($message, 201);
    }
}
