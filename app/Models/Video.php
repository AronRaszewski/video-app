<?php

namespace App\Models;

use App\VisibilityLevel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Video extends Model
{
    use HasFactory;

    protected $with = ['author'];

    protected $casts = [
        'visibility' => VisibilityLevel::class
    ];

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

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->whereNull('replied_to')->with('replies');
    }

    public function allowed(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'videos_allowed_for');
    }
}
