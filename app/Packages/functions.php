<?php

use App\Models\User;
use App\Packages\Response\Response;
use Illuminate\Support\Facades\Auth;

if (!function_exists('user')) {
    function user(string $guard = null): User
    {
        return Auth::guard($guard)->user();
    }
}

if (!function_exists('apiResponse')) {
    function apiResponse(): Response
    {
        return app(Response::class);
    }
}
