<?php

use function Pest\Laravel\json;

use App\Models\Task;
use App\Models\TodoList;
use Illuminate\Foundation\Testing\RefreshDatabase;



uses(RefreshDatabase::class);

test('fetch_all_tasks_of_a_todo_list', function () {

  $list = TodoList::factory()->create();
  Task::factory()->create(['todo_list_id' =>$list->id ]);

  $response = $this->getJson(route('todo-list.task.index', $list->id))->assertOk();

  $response->assertJsonCount(1);
});


test('store_task_for_a_todo_list', function () {

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

    $task = Task::factory()->create();

    $this->deleteJson(route('task.destroy', $task->id))
    ->assertNoContent();

    $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
});


test('update_task_of_todolist', function () {
  $task = Task::factory()->create();

  $this->patchJson(route('task.destroy', $task->id),  ['title' => $task->title])
  ->assertOk();

  $this->assertDatabaseHas('tasks', ['title' => $task->title ]);

});