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
        
        $response->assertOk();
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
        $response->assertForbidden();
        
        $response = $this->actingAs($user)->get(route('tags.create'));
        $response->assertForbidden();
        
        $response = $this->actingAs($user)->post(route('tags.store'));
        $response->assertForbidden();
        
        $response = $this->actingAs($user)->get(route('tags.edit', $this->tag));
        $response->assertForbidden();
        
        $response = $this->actingAs($user)->patch(route('tags.update', $this->tag));
        $response->assertForbidden();
        
        $response = $this->actingAs($user)->delete(route('tags.destroy', $this->tag));
        $response->assertForbidden();
    }
    
    public function test_tags_admin_routes_return_forbidden_response_for_guests(): void
    {
        $response = $this->get(route('tags.index'));
        $response->assertForbidden();
        
        $response = $this->get(route('tags.create'));
        $response->assertForbidden();
        
        $response = $this->post(route('tags.store'));
        $response->assertForbidden();
        
        $response = $this->get(route('tags.edit', $this->tag));
        $response->assertForbidden();
        
        $response = $this->patch(route('tags.update', $this->tag));
        $response->assertForbidden();
        
        $response = $this->delete(route('tags.destroy', $this->tag));
        $response->assertForbidden();
    }
}
