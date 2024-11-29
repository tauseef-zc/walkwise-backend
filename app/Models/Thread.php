<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $array)
 * @method static whereHas(string $string, \Closure $param)
 */
class Thread extends Model
{
    use HasFactory;

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'thread_id');
    }

    public function participants(): HasMany
    {
        return $this->hasMany(ThreadParticipant::class, 'thread_id');
    }

    public function getThreadNameAttribute(): string
    {
        $participants = $this->participants->filter(function ($participant) {
            return $participant->user_id != auth()->id();
        });

        return $participants->first()->user->name;
    }
}
