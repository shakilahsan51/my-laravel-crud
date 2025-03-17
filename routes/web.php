<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//This Route is for soft deleting
Route::get('/posts/trash', [PostController::class, 'trashed'])->name('posts.trashed');


//This is Resource Controller Route
Route::resource('posts', PostController::class);
