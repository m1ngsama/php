<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/communities', [CommunityController::class, 'index'])->name('communities.index');
Route::get('/r/{community}', [CommunityController::class, 'show'])->name('communities.show');

Route::middleware('auth')->group(function () {
    Route::get('/communities/create', [CommunityController::class, 'create'])->name('communities.create');
    Route::post('/communities', [CommunityController::class, 'store'])->name('communities.store');
    Route::post('/r/{community}/subscribe', [CommunityController::class, 'subscribe'])->name('communities.subscribe');
    Route::post('/r/{community}/unsubscribe', [CommunityController::class, 'unsubscribe'])->name('communities.unsubscribe');

    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    Route::post('/posts/{post}/vote', [VoteController::class, 'votePost'])->name('posts.vote');
    Route::post('/comments/{comment}/vote', [VoteController::class, 'voteComment'])->name('comments.vote');
});

Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::get('/u/{user}', [UserController::class, 'show'])->name('users.show');
