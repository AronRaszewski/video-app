<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Video;
use App\VisibilityLevel;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //

        Gate::define('show_video', function (?User $user, Video $video) {
            
            if ($user !== null && $video->user_id === $user->id)
                return true;

            if ($video->visibility === VisibilityLevel::Public)
                return true;

            if ($video->visibility === VisibilityLevel::Private)
                return false;

            if ($user === null)
                return false;

            return ($video->allowed->pluck('id')->contains($user->id));
        });
    }
}
