<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class RoleTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_case_simple()
    {
        Route::get('test-something', function (){
            return 'test';
        })->middleware('role:admin');

        $user = User::factory()->createOne();

        $this->actingAs($user)->get('test-something')->assertForbidden();

        $user->giveRoleTo('admin');

        $this->actingAs($user)->get('test-something')->assertSuccessful();
    }
}
