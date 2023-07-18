<?php

namespace Tests\Feature\Admin;

use App\Models\Checklist;
use App\Models\ChecklistGroup;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
   use RefreshDatabase;
    public function test_admin_can_access_to_Task_url(): void
    {
        $checklist_group = ChecklistGroup::factory()->create();
        $checklist = Checklist::factory()->create(['checklist_group_id'=>$checklist_group->id]);
        $admin = User::factory()->create(['is_admin'=>true]);
        $response = $this->actingAs($admin)->get('/admin/checklist_group/'.$checklist_group->id.'/checklist/'.$checklist->id.'/task');

        $response->assertStatus(200);
    }
}
