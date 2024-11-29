<?php

namespace App\Http\Controllers\V1\Api\Messaging;

use App\Http\Controllers\Controller;
use App\Models\Message;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Pusher\ApiErrorException;
use Pusher\Pusher;
use Pusher\PusherException;

class MessagesController extends Controller
{
    /**
     * @throws PusherException
     * @throws GuzzleException
     * @throws ApiErrorException
     */
    public function sendMessage(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'thread_id' => 'required|exists:threads,id',
            'user_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $message = Message::create($validated);

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            ['cluster' => env('PUSHER_APP_CLUSTER'), 'useTLS' => true]
        );

        $pusher->trigger('thread-' . $message->thread_id, 'message', $message);

        return response()->json(['message' => $message]);
    }

    public function fetchMessages(int $threadId): JsonResponse
    {
        $messages = Message::where('thread_id', $threadId)->orderBy('created_at', 'asc')->get();

        return response()->json(['messages' => $messages]);
    }
}
