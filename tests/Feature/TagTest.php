<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;
use App\Models\User;
use App\Models\Tag;

class TagTest extends TestCase
{
    use RefreshDatabase;

    private Tag $tag;

    protected function setUp(): void 
    {
        parent::setUp();

        $this->tag = Tag::factory()->create();
    }

    public function test_tags_index_route(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $response = $this->actingAs($admin)->get(route('tags.index'));
        
        $response->assertStatus(200);
        $response->assertInertia(function (Assert $page) {
            $page->component('tags/Index')
                ->has('tags', function (Assert $page) {
                    $page->has('data')
                        ->has('prev_page_url')
                        ->has('next_page_url')
                        ->etc();
                })
                ->has('categories')
                ->has('filters');
        });
    }

    public function test_tags_admin_routes_return_forbidden_response_for_non_admin_users(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('tags.index'));
        $response->assertStatus(403);
        
        $response = $this->actingAs($user)->get(route('tags.create'));
        $response->assertStatus(403);
        
        $response = $this->actingAs($user)->post(route('tags.store'));
        $response->assertStatus(403);
        
        $response = $this->actingAs($user)->get(route('tags.edit', $this->tag));
        $response->assertStatus(403);
        
        $response = $this->actingAs($user)->patch(route('tags.update', $this->tag));
        $response->assertStatus(403);
        
        $response = $this->actingAs($user)->delete(route('tags.destroy', $this->tag));
        $response->assertStatus(403);
    }
    
    public function test_tags_admin_routes_return_forbidden_response_for_guests(): void
    {
        $response = $this->get(route('tags.index'));
        $response->assertStatus(403);
        
        $response = $this->get(route('tags.create'));
        $response->assertStatus(403);
        
        $response = $this->post(route('tags.store'));
        $response->assertStatus(403);
        
        $response = $this->get(route('tags.edit', $this->tag));
        $response->assertStatus(403);
        
        $response = $this->patch(route('tags.update', $this->tag));
        $response->assertStatus(403);
        
        $response = $this->delete(route('tags.destroy', $this->tag));
        $response->assertStatus(403);
    }
}
