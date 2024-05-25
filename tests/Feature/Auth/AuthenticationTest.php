<?php

namespace Tests\Feature\Auth;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\User;
use Laravel\Passport\Passport;
use Database\Seeders\UserSeeder;
use Laravel\Passport\ClientRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Database\Factories\ClientFactory;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $client = app(ClientRepository::class)->createPasswordGrantClient(
            null, 'Test Password Grant Client', 'http://localhost'
        );

        Passport::client()->updateOrInsert(
            ['id' => $client->id],
            ['secret' => $client->secret]
        );

        config()->set('passport.personal_access_client.id', $client->_id);
        config()->set('passport.personal_access_client.secret', $client->secret);
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $response = $this
            ->withHeader('Accept', 'application/json')
            ->postJson('api/v1/login', [
                'mobile'   => $this->authUser()->mobile,
                'password' => '12345678',
            ]);

        $response->assertJsonStructure([
            'access_token'
        ]);
        $response->assertSuccessful();
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = $this->authUser();

        $this->post('/api/v1/login', [
            'email'    => $user->mobile,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest('api');
    }

    public function test_users_can_logout(): void
    {
        $user = $this->authUser();

        Passport::actingAs($user);

        $response = $this->postJson('/api/v1/logout');

        $this->assertDatabaseHas('oauth_access_tokens', [
            'revoked' => true,
        ]);

        $response->assertNoContent();
    }
}
