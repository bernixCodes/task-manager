<?php

use Illuminate\Foundation\Testing\RefreshDatabase;



uses(RefreshDatabase::class);

test('test_user_can_register)', function () {
   
    $this->postJson(route('user.register'), [ 
        'name' => "ben", 
        'email' => 'ben@gmail.com',
        'password' => 'root',
        'password_confirmation' => 'root'
    ])
    ->assertCreated();
    $this->assertDatabaseHas('users', ['name' => "ben"]);
});
