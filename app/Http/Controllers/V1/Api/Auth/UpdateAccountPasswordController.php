<?php

namespace App\Http\Controllers\V1\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdatePasswordRequest;
use App\Notifications\Auth\ResetPasswordNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class UpdateAccountPasswordController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdatePasswordRequest $request): JsonResponse
    {
        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'current_password' => ['The current password is incorrect.'],
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        $user->notify(new ResetPasswordNotification());

        return response()->json([], Response::HTTP_OK);
    }
}
