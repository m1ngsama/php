<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'community', 'comments'])
            ->orderBy('votes', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('home', compact('posts'));
    }
}
