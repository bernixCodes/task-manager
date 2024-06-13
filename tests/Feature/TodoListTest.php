<?php

use App\Models\TodoList;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\json;

uses(RefreshDatabase::class);

test('get_all_todo_list', function () {

    TodoList::factory()->create();

    $response = $this->getJson(route('todo-list.index'));

    $response->assertJsonCount(1);
});


test('get_single_todo_list', function () {
    $this->withoutExceptionHandling();
    
    $list = TodoList::factory()->create();
  

    $response = $this->getJson(route('todo-list.show', $list->id))->assertOk()->json();
  
    // $this->assertEquals( $response['name'] , $list->name);
});

test('store_new_todo_list', function () {
    $this->withoutExceptionHandling();

    $list = TodoList::factory()->make();

    $response = $this->postJson(route('todo-list.store'), ['name' => $list->name])
    ->assertCreated()->json();

    $this->assertEquals($list->name, $response['name']);

    $this->assertDatabaseHas('todo_lists', ['name' => $list->name]);
});

test('test_while_storing_todo_list_name_field_is_required', function () {

    $this->postJson(route('todo-list.store'))
     ->assertUnprocessable()

  ->assertJsonValidationErrors(['name']);

});


test('delete_todo_list', function () {
    $list = TodoList::factory()->create();

    $this->deleteJson(route('todo-list.destroy', $list->id))
    ->assertNoContent();

    $this->assertDatabaseMissing('todo_lists', ['id' => $list->id]);
});


test('update_todo_list', function () {
    $list = TodoList::factory()->create();

    $this->patchJson(route('todo-list.update', $list->id), ['name' => 'updated name'])
    ->assertOk();

    $this->assertDatabaseHas('todo_lists', ['id' => $list->id, 'name' => 'updated name']);
});


test('test_while_updating_todo_list_name_field_is_required', function () {
    $list = TodoList::factory()->create();

    $this->patchJson(route('todo-list.update', $list->id))
     ->assertUnprocessable()

  ->assertJsonValidationErrors(['name']);

});