<?php

use function Pest\Laravel\json;

use App\Models\Task;
use App\Models\TodoList;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

test('fetch_all_tasks_of_a_todo_list', function () {

  $user = User::factory()->create();
  Sanctum::actingAs($user);

  $list = TodoList::factory()->create();
  Task::factory()->create(['todo_list_id' =>$list->id ]);

  $response = $this->getJson(route('todo-list.task.index', $list->id))->assertOk();

  $response->assertJsonCount(1);
});


test('store_task_for_a_todo_list', function () {

  $user = User::factory()->create();
  Sanctum::actingAs($user);

    $task = Task::factory()->make();
    $list = TodoList::factory()->create();

    $this->postJson(route('todo-list.task.store', $list->id), ['title' => $task->title])
    ->assertCreated();

    $this->assertDatabaseHas('tasks', [
      'title' => $task->title , 
      'todo_list_id' =>$list->id
    ]);
});


test('delete_task_form_db', function () {

  $user = User::factory()->create();
  Sanctum::actingAs($user);

    $task = Task::factory()->create();

    $this->deleteJson(route('task.destroy', $task->id))
    ->assertNoContent();

    $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
});


test('update_task_of_todolist', function () {
  $user = User::factory()->create();
  Sanctum::actingAs($user);

  $task = Task::factory()->create();

  $this->patchJson(route('task.destroy', $task->id),  ['title' => $task->title])
  ->assertOk();

  $this->assertDatabaseHas('tasks', ['title' => $task->title ]);

});