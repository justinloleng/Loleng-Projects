<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ForumController;
use Illuminate\Support\Facades\Route;


//first make the main objectives
//create, read, update,edit, delete;
//make user register and login 
//reminder: cannot edit and delete using other user


Route::get('/threads', [ForumController::class, 'index'])->name('threads.index');
Route::get('/threads/create', [ForumController::class, 'create'])->name('threads.create');
Route::post('/threads', [ForumController::class, 'store'])->name('threads.store');
Route::get('/threads/{id}', [ForumController::class, 'show'])->name('threads.show');
Route::get('/threads/{id}/edit', [ForumController::class, 'edit'])->name('threads.edit');
Route::put('/threads/{id}', [ForumController::class, 'update'])->name('threads.update');
Route::delete('/threads/{id}', [ForumController::class, 'destroy'])->name('threads.destroy');

Route::post('/threads/{id}/replies', [ForumController::class, 'storeReply'])->name('replies.store');
Route::get('/replies/{id}/edit', [ForumController::class, 'editReply'])->name('replies.edit');
Route::put('/replies/{id}', [ForumController::class, 'updateReply'])->name('replies.update');
Route::delete('/replies/{id}', [ForumController::class, 'destroyReply'])->name('replies.destroy');



Route::get('/register', [UserController::class, 'showRegister'])->name('register.form');
Route::post('/register', [UserController::class, 'register'])->name('register');

Route::get('/login', [UserController::class, 'showLogin'])->name('login.form');
Route::post('/login', [UserController::class, 'login'])->name('login');

Route::get('/logout', [UserController::class, 'logout'])->name('logout');
