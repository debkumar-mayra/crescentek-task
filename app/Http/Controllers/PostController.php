<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;

class PostController extends Controller
{

    function profile()  {
        return Inertia::render('Profile');
    }

    function posts()  {
        $posts = Post::where('user_id',auth()->id())->get();
        return Inertia::render('Post',compact('posts'));
    }

    function addPost()  {
        request()->validate([
            'post_title'=>'required',
            'description'=>'required'
        ]);

        $post = new Post();
        $post->post_title = request()->post_title;
        $post->description = request()->description;
        $post->user_id = auth()->id();
        $post->save();

        return back()->with('success','successfully added');
    }

    function deletePost(User $user,  Post $post)  {
        $post->delete();
        return back()->with('success','successfully deleted');
    }


    function editPost(User $user, Post $post)  {
       
        $posts = Post::where('user_id',auth()->id())->get();
        return Inertia::render('Post',compact('posts','post'));
    }

    function updatePost(Post $post)  {
        request()->validate([
            'post_title'=>'required',
            'description'=>'required',
        ]);

        $post->post_title = request()->post_title;
        $post->description = request()->description;
        $post->save();

        return to_route('posts')->with('success','Successfully updated.');
    }
}
