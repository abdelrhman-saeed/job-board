<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;


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
        Passport::hashClientSecrets();
        Passport::enableImplicitGrant();
        Passport::tokensCan([
            'admin' => 'Admin privileges',
            'user' => 'User privileges',
        ]);
        Passport::enablePasswordGrant();
        Passport::useTokenModel(\Laravel\Passport\Token::class);
        Passport::useClientModel(\Laravel\Passport\Client::class);
    }
}
