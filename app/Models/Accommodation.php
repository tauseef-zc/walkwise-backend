<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Accommodation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'data',
        'guide_id'
    ];

    public function guide(): BelongsTo
    {
        return $this->belongsTo(Guide::class, 'guide_id');
    }

}
