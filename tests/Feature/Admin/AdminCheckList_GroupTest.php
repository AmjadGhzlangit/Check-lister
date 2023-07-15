<?php

namespace Tests\Feature;

use App\Models\ChecklistGroup;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminCheckList_GroupTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->create_user();
        $this->admin = $this->create_user($is_admin = true);
    }

    public function test_admin_can_see_pages_button_on_sidebar(): void
    {
        $response = $this->actingAs($this->admin)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Pages');
    }
    public function test_non_admin_cannot_see_pages_button_on_sidebar(): void
    {
        $response = $this->actingAs($this->user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertDontSee('Pages');
    }
    public function test_admin_can_access_pages_url(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/pages/index');

        $response->assertStatus(200);
    }
    public function test_non_admin_cannot_access_pages_url(): void
    {

        $response = $this->actingAs($this->user)->get('/admin/pages/index');

        $response->assertStatus(403);
        $response->assertForbidden();
    }

    public function test_the_create_form_display_correct(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/checklist_group/create');

        $response->assertStatus(200);
        $response->assertSee('Create CheckList Group');
    }

    public function test_admin_store_CheckListGroup_successfully_with_valid_data(): void
    {
        $checklist_group = ['name' => 'ChechList_Group one'];
        $response = $this->actingAs($this->admin)->post('/admin/checklist_group', $checklist_group);

        $response->assertStatus(302);
        $response->assertRedirect('dashboard');

        $last_checklist_group = ChecklistGroup::latest()->first();
        $this->assertDatabaseHas('checklist_groups', $checklist_group);
        $this->assertEquals($checklist_group['name'], $last_checklist_group['name']);
    }

    public function test_admin_store_validation_error_redirects_back_to_form_with_error_messages(): void
    {
        $checklist_group = ChecklistGroup::factory()->create(['name' => 'ChechList_Group one']);

        $response = $this->actingAs($this->admin)->post(
            '/admin/checklist_group',
            ['name' => 'ChechList_Group one']
        );

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name']);
        $response->assertInvalid(['name']);

        $this->assertDatabaseMissing('checklist_groups', $checklist_group->toArray());
    }

    public function test_edit_form_contains_correct_values(): void
    {
        $checklist_group = ChecklistGroup::factory()->create();


        $response = $this->actingAs($this->admin)->get('/admin/checklist_group/' . $checklist_group->id . '/edit');


        $response->assertStatus(200);
        $response->assertSee('value="' . $checklist_group->name . '"', false);
        $response->assertViewHas('checklist_group', $checklist_group);
    }

    public function test__CheckListGroup_update_successfully_with_valid_data(): void
    {
        $checklist_group = ChecklistGroup::factory()->create(['name' => 'ChechList_Group one']);

        $response = $this->actingAs($this->admin)->put('/admin/checklist_group/' . $checklist_group->id, ['name' => 'ChechList_Group two']);

        $response->assertStatus(302);
        $response->assertRedirect('dashboard');

        // $last_checklist_group = ChecklistGroup::latest()->first();
        $this->assertDatabaseHas('checklist_groups', ['name' => 'ChechList_Group two']);
        $this->assertDatabaseMissing('checklist_groups', ['name' => 'ChechList_Group one']);
    }

    public function test_CheckListGroup_update_validation_error_redirects_back_to_form_with_error_messages(): void
    {
        $checklist_group = ChecklistGroup::factory()->create(['name' => 'ChechList_Group one']);

        $response = $this->actingAs($this->admin)->put(
            'admin/checklist_group/' . $checklist_group->id,
            ['name' => '']
        );

        $response->assertStatus(302);
        
        $response->assertSessionHasErrors(['name']);
        $response->assertInvalid(['name']);
    }
    
    public function test_CheckListGroup_softDelete_successfully(): void
    {
        $checklist_group = ChecklistGroup::factory()->create();

        $response = $this->actingAs($this->admin)->delete(
            'admin/checklist_group/' . $checklist_group->id,
            
        );

        $response->assertStatus(302);
        $response->assertRedirect('dashboard');
       
        $this->assertDatabaseMissing('checklist_groups',$checklist_group->toArray());
        $this->assertDatabaseHas('checklist_groups',['deleted_at'=>now()]);
    }

    private function create_user(bool $is_admin = false): User
    {
        return  User::factory()->create([
            'is_admin' => $is_admin
        ]);
    }
}
