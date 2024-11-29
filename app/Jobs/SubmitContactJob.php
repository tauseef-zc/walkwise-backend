<?php

namespace App\Jobs;

use App\Enums\UserTypesEnum;
use App\Models\User;
use App\Notifications\Admin\ContactNotification as AdminContactNotification;
use App\Notifications\ContactNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class SubmitContactJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $messages;

    /**
     * Create a new job instance.
     */
    public function __construct(array $data)
    {
        $this->messages = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $users = User::where('is_admin', true)->get();
        Notification::send($users, new AdminContactNotification($this->messages));

        Notification::route('mail', [
            $this->messages['email'] =>  $this->messages['name']
        ])->notify(new ContactNotification());

    }
}
