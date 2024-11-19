<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Video extends Model
{
    use HasFactory;

    protected $with = ['author'];

    /**
     * Get the author that owns the Video
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get all of the rates for the Video
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rates(): HasMany
    {
        return $this->hasMany(Rate::class, 'video_id');
    }
}
