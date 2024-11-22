<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;
use App\Models\User;
use App\Models\Setting;
use App\Models\TagCategory;

class SettingTest extends TestCase
{
    use RefreshDatabase;

    public function test_settings_route(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $response = $this->actingAs($admin)->get(route('settings'));
        
        $response->assertOk();
        $response->assertInertia(function (Assert $page) {
            $page->component('Settings')
                ->has('tagCategories')
                ->has('settings');
        });
    }

    public function test_update_settings(): void 
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $tag_category = TagCategory::factory()->create();
        $setting = Setting::factory()->create([
            'name' => 'search_page_dropdown_tag_category_id',
            'value' => $tag_category->id,
        ]);

        $response = $this->actingAs($admin)
            ->post(route('settings.update', ['search_page_dropdown_tag_category_id' => $setting->value]));
        
        $response->assertRedirectToRoute('settings');
        $response->assertSessionHas('status', 'success');
        $this->assertEquals(
            $setting->value,
            Setting::where('name', 'search_page_dropdown_tag_category_id')->first()->value
        );
    }

    public function test_settings_input_validation_for_search_page_dropdown_tag_category_id(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $tag_category = TagCategory::factory()->create();
        $setting = Setting::factory()->create([
            'name' => 'search_page_dropdown_tag_category_id',
            'value' => null,
        ]);

        $response = $this->actingAs($admin)
            ->post(route('settings.update', ['search_page_dropdown_tag_category_id' => null]));
        $response->assertSessionDoesntHaveErrors('search_page_dropdown_tag_category_id');

        $response = $this->actingAs($admin)
            ->post(route('settings.update', ['search_page_dropdown_tag_category_id' => $tag_category->id]));
        $response->assertSessionDoesntHaveErrors('search_page_dropdown_tag_category_id');

        $response = $this->actingAs($admin)
            ->post(route('settings.update', ['search_page_dropdown_tag_category_id' => 'a']));
        $response->assertSessionHasErrors('search_page_dropdown_tag_category_id');

        $response = $this->actingAs($admin)
            ->post(route('settings.update', ['search_page_dropdown_tag_category_id' => 0]));
        $response->assertSessionHasErrors('search_page_dropdown_tag_category_id');
    }

    public function test_settings_admin_routes_return_forbidden_response_for_non_admin_users(): void
    {
        $user = User::factory()->create();
        $response = $this->get(route('settings'));
        $response->assertForbidden();

        $response = $this->get(route('settings.update'));
        $response->assertForbidden();
    }
    
    public function test_settings_admin_routes_return_forbidden_response_for_guests(): void
    {
        $response = $this->get(route('settings'));
        $response->assertForbidden();

        $response = $this->get(route('settings.update'));
        $response->assertForbidden();
    }
}
