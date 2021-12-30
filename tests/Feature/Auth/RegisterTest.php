<?php

namespace Feature\Auth;

use App\Http\Controllers\Auth\RegisterController;
use App\Models\User;
use Tests\TestCase;

class RegisterTest extends TestCase
{

    public function test_index() {
        $this->get('/register')->assertOk();
    }

    public function test_registration()
    {
        /* User to be tested */
        $testUser = [
            'username' => 'testusername',
            'password' => 'testpassword',
            'email' => 'testemail@example.com',
        ];

        /* Make sure it doesn't already exists */
        $user_id = User::where('username', '=', $testUser['username'])
            ->where('email', '=', $testUser['email'])
            ->post('id')[0]['id'];

        if ($user_id != null) {
            User::destroy(
                $user_id
            );
        }

        $this->assertDatabaseMissing(User::class, [
            'username' => $testUser['username'],
            'email' => $testUser['email'],
        ]);

        /* Register that user */
        $registerResponse = $this
            ->post('/register',
                [
                    'name' => 'Test User',
                    'username' => $testUser['username'],
                    'email' => $testUser['email'],
                    'password' => $testUser['password'],
                    'password_confirmation' => $testUser['password'],
                    'sex' => 'male',
                ]);

        $registerResponse->assertRedirect('/home');

        /* Make sure the user now exists in the Database */
        $this->assertDatabaseHas(User::class, [
            'username' => $testUser['username'],
            'email' => $testUser['email'],
        ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_login_registered_user()
    {
        /* Register the testuser */
        $this->test_registration();

        /* User to be tested */
        $testUser = [
            'username' => 'testusername',
            'password' => 'testpassword',
            'email' => 'testemail@example.com',
        ];

        /* Try to login with him */
        $loginResponse = $this
            ->get('/login', [
                'username' => $testUser['username'],
                'password' => $testUser['password'],
            ]);

        $loginResponse->assertRedirect('/home');
    }
}
