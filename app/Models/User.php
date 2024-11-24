<?php

namespace App\Models;

use App\Enums\GenderEnum;
use App\Enums\UserStatusEnum;
use App\Enums\UserTypesEnum;
use App\Traits\WithOtp;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes, WithOtp;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'gender',
        'nationality',
        'primary_lang',
        'other_lang',
        'newsletter',
        'is_admin',
        'status',
        'onboarding',
        'user_type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'newsletter' => 'boolean',
            'onboarding' => 'boolean',
            'other_lang' => 'array',
            'gender' => GenderEnum::class,
            'status' => UserStatusEnum::class,
            'user_type' => UserTypesEnum::class
        ];
    }

    /**
     * @param Panel $panel
     * @return bool
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->is_admin;
    }

    /**
     * @return string
     */
    public function getNameAttribute(): string
    {
        return $this->first_name.' '.$this->last_name;
    }

    /**
     * @return HasOne
     */
    public function guide(): HasOne
    {
        return $this->hasOne(Guide::class, 'user_id');
    }

    /**
     * @return HasOne
     */
    public function traveler(): HasOne
    {
        return $this->hasOne(Traveler::class, 'user_id');
    }

    /**
     * @return BelongsToMany
     */
    public function wishlist(): BelongsToMany
    {
        return $this->belongsToMany(Tour::class, 'wishlists', 'user_id', 'tour_id');
    }

    /**
     * @return HasMany
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'user_id');
    }
}
