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
        $response = $this->actingAs($user)
                         ->withSession(['email' =>  'connelly.henderson@example.com', 'password' => 'password'])
                         ->get('/');

        $response->assertStatus(200);
    }
}
