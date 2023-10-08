<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    function home()  {
        $todos = Todo::where('user_id',auth()->id())->get();
        return Inertia::render('Home',compact('todos'));
    }

    function addTodo()  {
        request()->validate([
            'todo_name'=>'required'
        ]);

        $todo = new Todo();
        $todo->todo_name = request()->todo_name;
        $todo->user_id = auth()->id();
        $todo->save();

        return back()->with('success','successfully added');
    }

    function deleteTodo(User $user,  Todo $todo)  {
         dd($todo);
        $todo->delete();
        return back()->with('success','successfully deleted');
    }

    function completeTodo(Todo $todo)  {
        $todo->is_complete =  2;
        $todo->save();
        return back()->with('success','successfully completed');
    }

    function editTodo(User $user, Todo $todo)  {
       
        $todos = Todo::where('user_id',auth()->id())->get();
        return Inertia::render('Home',compact('todos','todo'));
    }

    function updateTodo(Todo $todo)  {
        request()->validate([
            'todo_name'=>'required'
        ]);

        $todo->todo_name = request()->todo_name;
        $todo->save();

        return to_route('home')->with('success','Successfully updated.');
    }
}
