<?php

namespace App\Providers;

use App\Models\Classwork;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
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
       // App::setLocale('ar');
        
       Relation::enforceMorphMap(
            [
                'classwork' => Classwork::class,
                'post' => Post::class,
                'user' => User::class
            ],
        );
    }
}
