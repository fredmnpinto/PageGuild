<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\User;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example()
    {
        $user = User::find(1);

        $response = $this->actingAs($user)
                         ->withSession(['email' =>  $user->email, 'password' => 'password'])
                         ->get('/');

        $response->assertStatus(200);
    }
}
