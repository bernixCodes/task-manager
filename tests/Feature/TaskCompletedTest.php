<?php

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;



uses(RefreshDatabase::class);

test('test_a_task_status_can_be_changed', function () {

    $task = Task::factory()->create();

  $this->patchJson(route('task.update', $task->id),['status' => Task::STARTED ] );
  $this->assertDatabaseHas('tasks', ['status' => Task::STARTED ]);
});
