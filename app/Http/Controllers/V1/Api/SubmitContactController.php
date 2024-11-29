<?php

namespace App\Http\Controllers\V1\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Jobs\SubmitContactJob;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SubmitContactController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ContactRequest $request)
    {
        SubmitContactJob::dispatch($request->validated());

        return response()->json([], Response::HTTP_CREATED);
    }
}
