<?php

namespace Tests\Feature\Admin;

use App\Models\Checklist;
use App\Models\ChecklistGroup;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChecklistTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private User $admin;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = $this->create_user();
        $this->admin = $this->create_user($isAdmin = true);
    }


    /**
     * A basic feature test example.
     */
    public function test_admin_can_access_to_checklist_url(): void
    {
        $checklist_group = ChecklistGroup::factory()->create();
        $response = $this->actingAs($this->admin)->get('/admin/checklist_group/' . $checklist_group->id . '/checklist');

        $response->assertStatus(200);
    }

    public function test_non_admin_cannot_access_to_checklist_url(): void
    {
        $checklist_group = ChecklistGroup::create(['name' => 'checklist_group']);
        $response = $this->actingAs($this->user)->get('/admin/checklist_group/' . $checklist_group->id . '/checklist');

        $response->assertStatus(403);
    }

    public function test_admin_can_access_to_checklist_create_page(): void
    {
        $checklist_group = ChecklistGroup::factory()->create();


        $response = $this->actingAs($this->admin)->get('/admin/checklist_group/' . $checklist_group->id . '/checklist/create');

        $response->assertStatus(200);
        $response->assertSee('Add New CheckList');
    }

    public function test_non_admin_cannot_access_to_checklist_create_page(): void
    {
        $checklist_group = ChecklistGroup::factory()->create();

        $response = $this->actingAs($this->user)->get('/admin/checklist_group/' . $checklist_group->id . '/checklist/create');

        $response->assertStatus(403);
        $response->assertForbidden();
        $response->assertDontSee('Add New CheckList');
    }

    public function test_admin_store_checklist_successfully(): void
    {
        $checklist_group = ChecklistGroup::factory()->create();

        $checklist = [
            'name' => 'checklist one',
            'checklist_group_id' => $checklist_group->id,
        ];

        $response = $this->actingAs($this->admin)->post(
            '/admin/checklist_group/' . $checklist_group->id . '/checklist',
            $checklist
        );

        $response->assertStatus(302);
        $response->assertRedirect('dashboard');
        $this->assertDatabaseHas('checklists', $checklist);

        $checklist_latest = Checklist::latest()->first();
        $this->assertEquals($checklist['name'], $checklist_latest['name']);
        $this->assertEquals($checklist['checklist_group_id'], $checklist_latest['checklist_group_id']);
    }

    public function test_store_checklist_validation_error_redirects_back_to_form_with_error_messages(): void
    {
        $checklist_group = ChecklistGroup::factory()->create();
        $checklist = [
            'name' => '',
            'checklist_group_id' => $checklist_group->id,
        ];

        $response = $this->actingAs($this->admin)->post(
            '/admin/checklist_group/' . $checklist_group->id . '/checklist',
            $checklist
        );

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name']);
        $this->assertDatabaseMissing('checklists', $checklist);
        $this->assertDatabaseEmpty('checklists');
    }

    public function test_edit_checklist_form_contains_correct_data(): void
    {
        $checklist_group = ChecklistGroup::factory()->create();
        $checklist = Checklist::factory()->create(['checklist_group_id' => $checklist_group->id]);

        $response = $this->actingAs($this->admin)->get(
            '/admin/checklist_group/' . $checklist_group->id . '/checklist/' . $checklist->id . '/edit',

        );

        $response->assertStatus(200);
        $response->assertSee('value="' . $checklist->name . '"', false);
        // $response->assertSee("value=\"{$checklist->name}\"", false);

        $response->assertViewHas('checklist', $checklist);
    }

    public function test_admin_update_checklist_successfully(): void
    {
        $checklist_group = ChecklistGroup::factory()->create();

        $checklist = Checklist::factory()->create([
            'name' => 'checklist one',
            'checklist_group_id' => $checklist_group->id
        ]);

        $checklist_updated = ['name' => 'checklist one updated',];

        $response = $this->actingAs($this->admin)->put(
            '/admin/checklist_group/' . $checklist_group->id . '/checklist/' . $checklist->id . '',
            $checklist_updated
        );

        $response->assertStatus(302);
        $response->assertRedirect('dashboard');

        $checklist_latest = Checklist::latest()->first();
        $this->assertDatabaseHas('checklists', ['name' => 'checklist one updated']);
        $this->assertDatabaseMissing('checklists', ['name' => 'checklist one']);
        $this->assertEquals($checklist_updated['name'], $checklist_latest['name']);
        $this->assertEquals($checklist['checklist_group_id'], $checklist_latest['checklist_group_id']);
    }

    public function test_CheckListGroup_update_validation_error_redirects_back_to_form_with_error_messages(): void
    {
        $checklist_group = ChecklistGroup::factory()->create();

        $checklist = Checklist::factory()->create([
            'name' => 'checklist one',
            'checklist_group_id' => $checklist_group->id
        ]);


        $response = $this->actingAs($this->admin)->put(
            '/admin/checklist_group/' . $checklist_group->id . '/checklist/' . $checklist->id . '',
            [
                'name' => '',
                'checklist_group_id' => $checklist_group->id
            ]
        );

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name']);
        $this->assertDatabaseHas('checklists', ['name' => 'checklist one']);
        
    }  

    public function test_admin_CheckList_softDelete_successfully(): void
    {
        $checklist_group = ChecklistGroup::factory()->create();

        $checklist = Checklist::factory()->create([
            'name' => 'checklist one',
            'checklist_group_id' => $checklist_group->id
        ]);

        $response = $this->actingAs($this->admin)->delete(
            '/admin/checklist_group/' . $checklist_group->id . '/checklist/' . $checklist->id . '',
            $checklist->toArray()
        );

        $response->assertStatus(302);
        $response->assertRedirect('dashboard');

        $this->assertDatabaseMissing('checklists',$checklist->toArray());
        $this->assertDatabaseHas('checklists',['deleted_at'=>now()]);
    }

    
    private function create_user(bool $isAdmin = false): User
    {
        return User::factory()->create(['is_admin' => $isAdmin]);
    }
}
