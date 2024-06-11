<?php

use App\Models\TodoList;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('get_todo_list', function () {
 
    $this->withoutExceptionHandling();

    // TodoList::create(['name' => 'my list']);
    $list = TodoList::factory()->create();

    $response = $this->getJson(route('todo-list.index'));


    //  Check the status is 200
    $response->assertStatus(200);

     // Checking the response has exactly one item
    $response->assertJsonCount(1);
});
