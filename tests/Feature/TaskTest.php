<?php

use function Pest\Laravel\json;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;



uses(RefreshDatabase::class);

test('fetch_all_tasks_of_a_todo_list', function () {

  Task::factory()->create();

  $response = $this->getJson(route('task.index'))->assertOk();

  $response->assertJsonCount(1);
});


test('store_task_for_a_todo_list', function () {

    $task = Task::factory()->make();

    $this->postJson(route('task.store'), ['title' => $task->title])
    ->assertCreated();

    $this->assertDatabaseHas('tasks', ['title' => $task->title ]);
});


test('delete_task_form_db', function () {

    $task = Task::factory()->create();

    $this->deleteJson(route('task.destroy', $task->id))
    ->assertNoContent();

    $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
});