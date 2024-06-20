<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;



uses(RefreshDatabase::class);
test('test_user_can_login', function () {
   $user =  User::factory()->create();

   $response = $this->postJson(route('user.login'), [ 
        'email' => $user->email,
        'password' => 'root',
   ])
   ->assertOk();
    //  ->dd();
    
    // $this->assertJsonStructure(['token']);
    $this->assertArrayHasKey('token',$response->json());
});


test('test_if_user_email_is_not_available_then_returns_error', function () {
     $this->postJson(route('user.login'), [ 
         'email' => 'ben8@gmail.com',
         'password' => 'root',
     ])
     ->assertUnauthorized();
     
 });


 test('test_if_user_password_is_incorrect_and_returns_error', function () {
    $user =  User::factory()->create();
    $this->postJson(route('user.login'), [ 
        'email' => $user->email,
        'password' => 'mistake',
    ])
    ->assertUnauthorized();
    
});