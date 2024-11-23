<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;
use App\Models\User;
use App\Http\Middleware\EnsureUserIsAdmin;

class EnsureUserIsAdminTest extends TestCase
{
    use RefreshDatabase;

    private $middleware;
    private $route;
    private $testUrl;

    public function setUp(): void
    {
        parent::setUp();

        $this->testUrl = '/test-ensure-user-is-admin';
        $this->middleware = new EnsureUserIsAdmin;

        \Route::middleware('admin')->get($this->testUrl, function () { return ''; });
    }

    public function test_allow_admin_access(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get($this->testUrl);

        $response->assertOk();
    }

    public function test_disallows_guest_access(): void
    {
        $response = $this->get($this->testUrl);

        $response->assertForbidden();
    }

    public function test_disallows_non_admin_user_access(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->get($this->testUrl);

        $response->assertForbidden();
    }
}
