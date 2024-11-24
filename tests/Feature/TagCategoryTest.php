<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Inertia\Testing\AssertableInertia as Assert;
use App\Models\User;
use App\Models\TagCategory;

class TagCategoryTest extends TestCase
{
    use RefreshDatabase;

    private TagCategory $tag_category;

    protected function setUp(): void 
    {
        parent::setUp();

        $this->tag_category = TagCategory::factory()->create();
    }

    public function test_tag_categories_index_route(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $response = $this->actingAs($admin)->get(route('tagCategories.index'));
        
        $response->assertOk();
        $response->assertInertia(function (Assert $page) {
            $page->component('tagCategories/Index')
                ->has('categories', function (Assert $page) {
                    $page->has('data')
                        ->has('prev_page_url')
                        ->has('next_page_url')
                        ->etc();
                });
        });
    }

    public function test_tag_categories_admin_routes_return_forbidden_response_for_non_admin_users(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('tagCategories.index'));
        $response->assertForbidden();
    }
    
    public function test_tag_categories_admin_routes_return_forbidden_response_for_guests(): void
    {
        $response = $this->get(route('tagCategories.index'));
        $response->assertForbidden();
    }
}
