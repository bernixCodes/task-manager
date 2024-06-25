<?php

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

test('test_a_task_status_can_be_changed', function () {

  $user = User::factory()->create();
  Sanctum::actingAs($user);

    $task = Task::factory()->create();

  $this->patchJson(route('task.update', $task->id),['status' => Task::STARTED ] );
  $this->assertDatabaseHas('tasks', ['status' => Task::STARTED ]);
});
