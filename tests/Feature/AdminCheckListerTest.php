<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminCheckListerTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_admin_can_see_pages_button_on_sidebar(): void
    {
       $admin= User::factory()->create(['is_admin'=>true]);

        $response = $this->actingAs($admin)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Pages');
    }
    public function test_non_admin_cannot_see_pages_button_on_sidebar(): void
    {
       $user= User::factory()->create(['is_admin'=>false]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertDontSee('Pages');
    }
    public function test_admin_can_access_pages_url(): void
    {
       $admin= User::factory()->create(['is_admin'=>true]);

        $response = $this->actingAs($admin)->get('/admin/pages/index');

        $response->assertStatus(200);
    }
    public function test_non_admin_cannot_access_pages_url(): void
    {
       $admin= User::factory()->create(['is_admin'=>false]);

        $response = $this->actingAs($admin)->get('/admin/pages/index');

        $response->assertStatus(403);
        $response->assertForbidden();
    }
}
