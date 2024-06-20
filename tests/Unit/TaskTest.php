<?php

use App\Models\Task;
use App\Models\TodoList;
use Illuminate\Foundation\Testing\RefreshDatabase;
uses(Tests\TestCase::class);

uses(RefreshDatabase::class);

test('test_task_belongs_to_a_todo_list', function () {
    $list = TodoList::factory()->create();
    $task = Task::factory()->create(['todo_list_id' => $list->id]);

    $this->assertInstanceOf(TodoList::class, $task->todo_list);
});
