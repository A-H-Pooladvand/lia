<?php

namespace App\Providers;

use App\Models\Token;
use App\Models\Client;
use App\Models\AuthCode;
use App\Models\RefreshToken;
use Laravel\Passport\Passport;
use App\Models\PersonalAccessClient;
use Illuminate\Foundation\AliasLoader;
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
        Passport::enablePasswordGrant();

        $loader = AliasLoader::getInstance();
        $loader->alias(\Laravel\Passport\AuthCode::class, AuthCode::class);
        $loader->alias(\Laravel\Passport\Client::class, Client::class);
        $loader->alias(\Laravel\Passport\Token::class, Token::class);
        $loader->alias(\Laravel\Passport\PersonalAccessClient::class, PersonalAccessClient::class);
        $loader->alias(\Laravel\Passport\RefreshToken::class, RefreshToken::class);
    }
}
