<?php

namespace App\Http\Controllers\V1\Api\Messaging;

use App\Http\Controllers\Controller;
use App\Http\Resources\Messaging\ThreadResource;
use App\Models\Thread;
use App\Models\ThreadParticipant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function createThread(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'participants' => 'required|array|min:2',
            'participants.*' => 'exists:users,id',
        ]);

        $thread = Thread::create([]);

        foreach ($validated['participants'] as $userId) {
            ThreadParticipant::create([
                'thread_id' => $thread->id,
                'user_id' => $userId,
            ]);
        }

        return response()->json(['thread' => $thread]);
    }

    public function fetchUserThreads($userId): JsonResponse
    {
        $threads = Thread::whereHas('participants', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();

        $threads->load('participants');

        return response()->json(['threads' => ThreadResource::collection($threads)]);
    }
}
