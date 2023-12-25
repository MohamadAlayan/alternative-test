<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;

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
        // https://stackoverflow.com/questions/68140778/using-laravel-8-with-sanctum-hasapitokens-to-login-with-a-remember-me-option/68627328#68627328
        Sanctum::authenticateAccessTokensUsing(function (PersonalAccessToken $token, $isValid) {
            if($isValid) return true;
            return $token->can('remember') && $token->created_at->gt(now()->subMonths(3));
        });
    }
}
