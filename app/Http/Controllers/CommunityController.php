<?php

namespace App\Http\Controllers;

use App\Models\Community;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    public function index()
    {
        $communities = Community::withCount(['posts', 'subscribers'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('communities.index', compact('communities'));
    }

    public function show(Community $community)
    {
        $posts = $community->posts()
            ->with(['user', 'comments'])
            ->orderBy('votes', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('communities.show', compact('community', 'posts'));
    }

    public function create()
    {
        return view('communities.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:communities',
            'description' => 'nullable|string',
        ]);

        $community = Community::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('communities.show', $community)
            ->with('success', 'Community created successfully!');
    }

    public function subscribe(Community $community)
    {
        auth()->user()->subscribedCommunities()->attach($community->id);
        return back()->with('success', 'Subscribed to ' . $community->name);
    }

    public function unsubscribe(Community $community)
    {
        auth()->user()->subscribedCommunities()->detach($community->id);
        return back()->with('success', 'Unsubscribed from ' . $community->name);
    }
}
