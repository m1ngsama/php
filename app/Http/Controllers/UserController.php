<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(User $user)
    {
        $posts = $user->posts()
            ->with(['community', 'comments'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $comments = $user->comments()
            ->with(['post', 'post.community'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('users.show', compact('user', 'posts', 'comments'));
    }
}
