<?php

namespace App\Http\Controllers;

use App\Events\ChannelChat;
use App\Events\ChannelMessage;
use App\Events\CloseChat;
use App\Events\SendMessage;
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
     * Get Chats Actives
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $chats = Chat::where('closed', 0)->get();
        return response()->json($chats, 200);
    }

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
            'username' => $chat->username
        ]);

        broadcast(new ChannelChat($chat->title, $chat->username, $chat->id, $chat->created_at));

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
    public function close(string $id, Request $request): JsonResponse
    {
        $chat = Chat::findOrFail($id);
        $username = $request->name;

        $message = (object) [
            'chat_id' => $chat->id,
            'username' => 'Hypeone Chat:',
            'content' => $username . ' encerrou esse chat.',
            'created_at' => date('Y-m-d H:i:s'),
        ];

        if ($chat) {
            $chat->update(['closed' => true]);
            session()->forget(['chat_id', 'title', 'name']);

            broadcast(new SendMessage($message))->toOthers();
            broadcast(new CloseChat($chat->id))->toOthers();

            return response()->json($chat, 200);
        }

        return response()->json(['error' => 'Chat não encontrado.'], 404);
    }

    /**
     * Accept Client Join in Chat
     *
     * @param string $id
     * @return JsonResponse
     */
    public function join(string $id): JsonResponse
    {
        $chat = Chat::find($id);
        $user = Auth::user();

        session()->put([
            'chat_id' => $chat->id,
            'title' => $chat->title,
            'username' => $user->name
        ]);

        $message = (object) [
            'username' => 'Hypeone Chat:',
            'content' => $user->name . ' entrou no chat.',
            'chat_id' => $chat->id,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        broadcast(new SendMessage($message));

        return response()->json($chat, 201);
    }
}
