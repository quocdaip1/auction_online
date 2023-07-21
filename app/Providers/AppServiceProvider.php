<?php

namespace App\Providers;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        view()->composer('*', function ($view) {
            if (auth()->check()) {
                $user_id = Auth::User()->id;
                $user_login = User::join('user_info', 'users.id', 'user_info.user_id')
                    ->select('users.id', 'users.email', 'user_info.name', 'user_info.address', 'user_info.phone', 'user_info.avatar', 'users.balance')
                    ->where('users.id', $user_id)
                    ->first();
                $view->with(['user_login' => $user_login]);
            } else {
                $view->with(['user_login' => null]);
            }
        });

    }
}