<?php

use App\Models\Task;
use App\Models\TodoList;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class);

uses(RefreshDatabase::class);

test('test_a_todo_list_has_many_tasks', function () {
   
    $list = TodoList::factory()->create();
    $task = Task::factory()->create(['todo_list_id' => $list->id]);

    $this->assertInstanceOf(Task::class, $list->tasks->first());
});
