<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\UserController
 */
final class UserControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $users = User::factory()->count(3)->create();

        $response = $this->get(route('users.index'));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'email'
                ]
            ]
        ]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\UserController::class,
            'store',
            \App\Http\Requests\UserStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {

        $user = User::factory()->create();
        $this->actingAs($user); // Authenticate the user
        $name = $this->faker->name();
        $email = $this->faker->safeEmail();
        $password = bcrypt($this->faker->password());
        $password_salt = bcrypt($this->faker->password());
        $last_login = now();
        $account_typ = $this->faker->randomElement(['admin', 'user', 'customer']);
        $active = $this->faker->boolean();
        $blocked = $this->faker->boolean();
        $email_verified_at = now();
        $remember_token = $this->faker->password();

        $response = $this->post(route('users.store'), [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_salt' => $password_salt,
            'account_typ' => $account_typ,
            'active' => $active,
            'blocked' => $blocked,
            'remember_token' => $remember_token,
        ]);

        $users = User::query()
            ->where('name', $name)
            ->where('email', $email)
            ->get();
        $this->assertCount(1, $users);

        $response->assertCreated();
        $response->assertJsonStructure(
            [
                'data' => [
                    'name',
                    'email',
                    'id',
                ]
             ]
        );
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $user = User::factory()->create();

        $response = $this->get(route('users.show', $user));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id', 'name', 'email'
            ]
        ]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\UserController::class,
            'update',
            \App\Http\Requests\UserUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $user = User::factory()->create();
        $name = $this->faker->name();
        $email = $this->faker->safeEmail();

        $response = $this->put(route('users.update', $user), [
            'name' => $name,
            'email' => $email,

        ]);

        $user->refresh();

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id', 'name', 'email'
            ]
        ]);

        $this->assertEquals($name, $user->name);
        $this->assertEquals($email, $user->email);
    }

    #[Test]
    public function methods_behaves_as_expected(): void
    {
        $response = $this->get('api/users/methods');
        $response->assertOk();
        $response->assertJson([
            'methods' => ['GET', 'POST', 'PUT', 'DELETE']
        ]);
    }
}
