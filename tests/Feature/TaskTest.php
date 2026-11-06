<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::create([
            'name' => 'Primary User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
        ]);
    }

    public function test_guest_is_redirected_to_login_when_visiting_dashboard(): void
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_dashboard_with_stats(): void
    {
        // Create sample tasks
        $this->user->tasks()->create([
            'title' => 'Pending Task',
            'priority' => 'medium',
            'status' => 'pending',
        ]);
        $this->user->tasks()->create([
            'title' => 'In Progress Task',
            'priority' => 'high',
            'status' => 'in_progress',
        ]);
        $this->user->tasks()->create([
            'title' => 'Completed Task',
            'priority' => 'low',
            'status' => 'completed',
        ]);

        $response = $this->actingAs($this->user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Pending Task');
        $response->assertSee('In Progress Task');
        $response->assertSee('Completed Task');
    }

    public function test_user_can_create_a_new_task(): void
    {
        $taskData = [
            'title' => 'Write Automated Unit Tests',
            'description' => 'Cover all core workflows with PHPUnit.',
            'priority' => 'high',
            'status' => 'pending',
            'due_date' => Carbon::tomorrow()->format('Y-m-d'),
        ];

        $response = $this->actingAs($this->user)->post('/tasks', $taskData);

        $response->assertRedirect('/tasks');
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('tasks', [
            'user_id' => $this->user->id,
            'title' => 'Write Automated Unit Tests',
            'priority' => 'high',
        ]);
    }

    public function test_user_can_update_their_own_task(): void
    {
        $task = $this->user->tasks()->create([
            'title' => 'Original Title',
            'priority' => 'low',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->user)->put("/tasks/{$task->id}", [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'priority' => 'high',
            'status' => 'in_progress',
        ]);

        $response->assertRedirect('/tasks');
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Updated Title',
            'priority' => 'high',
            'status' => 'in_progress',
        ]);
    }

    public function test_user_can_toggle_task_status(): void
    {
        $task = $this->user->tasks()->create([
            'title' => 'Toggle Status Task',
            'priority' => 'medium',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->user)->patch("/tasks/{$task->id}/toggle-status");

        $response->assertStatus(302);
        $this->assertEquals('completed', $task->fresh()->status);

        // Toggle back to pending
        $this->actingAs($this->user)->patch("/tasks/{$task->id}/toggle-status");
        $this->assertEquals('pending', $task->fresh()->status);
    }

    public function test_user_can_delete_task(): void
    {
        $task = $this->user->tasks()->create([
            'title' => 'Task To Delete',
            'priority' => 'low',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->user)->delete("/tasks/{$task->id}");

        $response->assertStatus(302);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_user_cannot_access_or_modify_another_users_task(): void
    {
        $otherUser = User::create([
            'name' => 'Stranger',
            'email' => 'stranger@example.com',
            'password' => Hash::make('password'),
        ]);

        $strangerTask = $otherUser->tasks()->create([
            'title' => 'Stranger Secret Task',
            'priority' => 'high',
            'status' => 'pending',
        ]);

        // Attempt to view
        $viewResponse = $this->actingAs($this->user)->get("/tasks/{$strangerTask->id}");
        $viewResponse->assertStatus(403);

        // Attempt to edit
        $editResponse = $this->actingAs($this->user)->get("/tasks/{$strangerTask->id}/edit");
        $editResponse->assertStatus(403);

        // Attempt to update
        $updateResponse = $this->actingAs($this->user)->put("/tasks/{$strangerTask->id}", [
            'title' => 'Hacked Task',
            'priority' => 'low',
            'status' => 'completed',
        ]);
        $updateResponse->assertStatus(403);

        // Attempt to delete
        $deleteResponse = $this->actingAs($this->user)->delete("/tasks/{$strangerTask->id}");
        $deleteResponse->assertStatus(403);

        // Verify task remains untouched
        $this->assertDatabaseHas('tasks', [
            'id' => $strangerTask->id,
            'title' => 'Stranger Secret Task',
        ]);
    }
}

