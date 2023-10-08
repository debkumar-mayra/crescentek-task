<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Auth\AdminAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::match(['get','post'],'/',[ AuthController::class,'login'])->name('login');
Route::match(['get','post'],'/sign-up',[ AuthController::class,'signUp'])->name('signUp');

Route::middleware(['auth'])->group(function(){
    Route::post('/logout',[ AuthController::class,'logout'])->name('logout');
    Route::get('/profile',[ PostController::class,'profile'])->name('profile');
    Route::get('/posts',[ PostController::class,'posts'])->name('posts');
    Route::post('/add-post',[ PostController::class,'addPost'])->name('addPost');
    Route::get('user/{user}/post/{post}',[ PostController::class,'editPost'])->name('editPost')->scopeBindings();
    Route::post('/update-post/{post}',[ PostController::class,'updatePost'])->name('updatePost');
    Route::delete('user/{user}/post/{post}',[ PostController::class,'deletePost'])->name('deletePost')->scopeBindings();
});


Route::prefix('admin/')->middleware(['TestMiddleware'])->group(function() {
    Route::get('/dashboard',[ AdminAuthController::class,'dashboard'])->name('admindashbord');
});


Route::get('/user-name-only',function(){
  return  User::find(1,['name']);
});


Route::get('/chunk',function(){
    User::latest()->chunk(1000, function ($users) {
        foreach ($users as $user) {
            echo $user->id.'. '.$user->name.'<br/>';
        }
        echo '-----------chunk<br/>';
    });
  });


  Route::get('/post-user',function(){
   return User::has('posts')->orHas('comments')->get();
  });




