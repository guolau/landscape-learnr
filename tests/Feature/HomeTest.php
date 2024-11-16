<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Database\Seeders\TestSeeder;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void 
    {
        parent::setUp();

        $this->seed(TestSeeder::class);
    }

    public function test_home_for_guests_returns_a_successful_response(): void 
    {
        $response = $this->get(route('home'));
        
        $response->assertStatus(200);
    }

    public function test_home_for_users_returns_a_successful_response(): void 
    {
        $user = User::factory()->create();
    
        $response = $this->actingAs($user)->get(route('home'));
        
        $response->assertStatus(200);
    }
}
