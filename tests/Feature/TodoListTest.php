<?php

use App\Models\TodoList;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;


uses(RefreshDatabase::class);


test('get_all_todo_list', function () {

    $user = User::factory()->create();
    Sanctum::actingAs($user);

    TodoList::factory()->create(['user_id' => $user->id]);

    $response = $this->getJson(route('todo-list.index'));

    $response->assertStatus(200);
    $response->assertJsonCount(1);
});


test('get_single_todo_list', function () {
    $this->withoutExceptionHandling();
    
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $list = TodoList::factory()->create();
  

    $response = $this->getJson(route('todo-list.show', $list->id))->assertOk()->json();
  
    // $this->assertEquals( $response['name'] , $list->name);
});

test('store_new_todo_list', function () {
    $this->withoutExceptionHandling();

    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $list = TodoList::factory()->make(['user_id' => $user->id]);

    $response = $this->postJson(route('todo-list.store'), ['name' => $list->name])
    ->assertCreated()->json();

    $this->assertEquals($list->name, $response['name']);

    $this->assertDatabaseHas('todo_lists', ['name' => $list->name]);
});

test('test_while_storing_todo_list_name_field_is_required', function () {

    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $this->postJson(route('todo-list.store'))
     ->assertUnprocessable()

  ->assertJsonValidationErrors(['name']);

});


test('delete_todo_list', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $list = TodoList::factory()->create();

    $this->deleteJson(route('todo-list.destroy', $list->id))
    ->assertNoContent();

    $this->assertDatabaseMissing('todo_lists', ['id' => $list->id]);
});


test('update_todo_list', function () {

    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $list = TodoList::factory()->create();

    $this->patchJson(route('todo-list.update', $list->id), ['name' => 'updated name'])
    ->assertOk();

    $this->assertDatabaseHas('todo_lists', ['id' => $list->id, 'name' => 'updated name']);
});


test('test_while_updating_todo_list_name_field_is_required', function () {

    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $list = TodoList::factory()->create(['user_id' => $user->id]);

    $this->patchJson(route('todo-list.update', $list->id))
     ->assertUnprocessable()

  ->assertJsonValidationErrors(['name']);

});