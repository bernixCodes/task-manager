<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TodoList;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TodoListController extends Controller
{
    public function index(){
        $lists = TodoList::all();
        return response($lists);
    }

    public function show(TodoList $todo_list){
 
        return response($todo_list);
    }


    public function store(Request $request){

       $request->validate(['name' => ['required']]);
       $todo_list =  TodoList::create($request->all());
 
        return $todo_list;
    }


    public function destroy(TodoList $todo_list){
        $todo_list ->delete();
       return response('', Response::HTTP_NO_CONTENT);
    }

    public function update(Request $request, TodoList $todo_list ){
        $request->validate(['name' => ['required']]);
        $todo_list ->update($request->all());
        return response($todo_list );
     }


}

