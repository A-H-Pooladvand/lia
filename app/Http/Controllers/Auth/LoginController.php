<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Requests\Auth\LoginRequest;

class LoginController
{
    /**
     * @throws \JsonException
     */
    public function __invoke(LoginRequest $request)
    {
        $response = Request::create('/oauth/token', 'POST', [
            'grant_type'    => 'password',
            'client_id'     => config('passport.personal_access_client.id'),
            'client_secret' => config('passport.personal_access_client.secret'),
            'username'      => $request->input('mobile'),
            'password'      => $request->input('password'),
            'scope'         => '*',
        ]);

        $response = App::handle($response);

        $content = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);

        return response()->json($content, $response->getStatusCode());
    }
}
