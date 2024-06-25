<?php

use App\Models\TodoList;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class);
uses(RefreshDatabase::class);

test('user_has_many_todo_lists', function () {
    $user = User::factory()->create();
    $list = TodoList::factory()->create(['user_id' => $user->id]);

    $this->assertInstanceOf(TodoList::class, $user->todo_lists->first());
});
