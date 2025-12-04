<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function create()
    {
        $communities = Community::orderBy('name')->get();
        return view('posts.create', compact('communities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'community_id' => 'required|exists:communities,id',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'url' => 'nullable|url',
            'type' => 'required|in:text,link,image',
        ]);

        $post = Post::create([
            'community_id' => $validated['community_id'],
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'content' => $validated['content'] ?? null,
            'url' => $validated['url'] ?? null,
            'type' => $validated['type'],
        ]);

        return redirect()->route('posts.show', $post)
            ->with('success', 'Post created successfully!');
    }

    public function show(Post $post)
    {
        $post->load(['user', 'community', 'comments.user', 'comments.replies.user']);
        return view('posts.show', compact('post'));
    }

    public function destroy(Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }

        $post->delete();
        return redirect('/')->with('success', 'Post deleted successfully!');
    }
}
