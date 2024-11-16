<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;
use Database\Seeders\TestSeeder;
use App\Models\User;
use App\Models\TagCategory;
use App\Models\Setting;

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
        $this->assertInertiaResponse($response);
    }

    public function test_home_for_users_returns_a_successful_response(): void 
    {
        $user = User::factory()->create();
    
        $response = $this->actingAs($user)->get(route('home'));
        
        $response->assertStatus(200);
        $this->assertInertiaResponse($response);
    }

    public function test_has_correct_tag_category(): void {
        $response = $this->get(route('home'));
        $response->assertInertia(function (Assert $page) {
            $page->component('Home')
                ->where('tagCategory', null);
        });

        $category = TagCategory::factory()->create();
        Setting::where('name', 'search_page_dropdown_tag_category_id')->update([
            'value' => $category->id,
        ]);
        $response = $this->get(route('home'));
        $response->assertInertia(function (Assert $page) use ($category) {
            $page->component('Home')
                ->has('tagCategory', function (Assert $page) use ($category) {
                    $page->where('id', $category->id)
                        ->etc();
                });
        });
    }

    private function assertInertiaResponse($response) {
        $response->assertInertia(function (Assert $page) {
            $page->component('Home')
                ->has('tagCategory')
                ->has('tags')
                ->has('snippets', function (Assert $page) {
                    $page->has('data')
                        ->has('prev_page_url')
                        ->has('next_page_url')
                        ->etc();
                })
                ->has('filters');
        });
    }
}
