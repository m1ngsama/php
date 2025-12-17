@extends('layout')

@section('title', 'r/' . $community->name)

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <h1 class="text-3xl font-bold mb-6">r/{{ $community->name }}</h1>

        @forelse($posts as $post)
            <div class="bg-white rounded-lg shadow mb-4 p-4 flex">
                <div class="flex flex-col items-center mr-4">
                    @auth
                        <form action="{{ route('posts.vote', $post) }}" method="POST">
                            @csrf
                            <input type="hidden" name="vote" value="1">
                            <button type="submit" class="text-gray-400 hover:text-orange-600">▲</button>
                        </form>
                    @else
                        <span class="text-gray-400">▲</span>
                    @endauth

                    <span class="font-bold {{ $post->votes > 0 ? 'text-orange-600' : ($post->votes < 0 ? 'text-blue-600' : 'text-gray-600') }}">
                        {{ $post->votes }}
                    </span>

                    @auth
                        <form action="{{ route('posts.vote', $post) }}" method="POST">
                            @csrf
                            <input type="hidden" name="vote" value="-1">
                            <button type="submit" class="text-gray-400 hover:text-blue-600">▼</button>
                        </form>
                    @else
                        <span class="text-gray-400">▼</span>
                    @endauth
                </div>

                <div class="flex-1">
                    <h2 class="text-xl font-semibold mb-2">
                        <a href="{{ route('posts.show', $post) }}" class="hover:text-orange-600">{{ $post->title }}</a>
                    </h2>
                    <div class="text-sm text-gray-600 mb-2">
                        Posted by <a href="{{ route('users.show', $post->user) }}" class="hover:underline">u/{{ $post->user->name }}</a>
                        • {{ $post->created_at->diffForHumans() }}
                    </div>
                    @if($post->content)
                        <p class="text-gray-700 mb-2">{{ Str::limit($post->content, 200) }}</p>
                    @endif
                    @if($post->url)
                        <a href="{{ $post->url }}" target="_blank" class="text-blue-600 hover:underline">{{ $post->url }}</a>
                    @endif
                    <div class="mt-2">
                        <a href="{{ route('posts.show', $post) }}" class="text-gray-600 hover:underline">
                            {{ $post->comments->count() }} comments
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-gray-600">No posts yet. Be the first to post!</p>
        @endforelse

        <div class="mt-4">
            {{ $posts->links() }}
        </div>
    </div>

    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow p-4">
            <h2 class="text-xl font-bold mb-4">About r/{{ $community->name }}</h2>
            @if($community->description)
                <p class="text-gray-700 mb-4">{{ $community->description }}</p>
            @endif
            <div class="text-sm text-gray-600 mb-4">
                Created by <a href="{{ route('users.show', $community->creator) }}" class="hover:underline">u/{{ $community->creator->name }}</a>
                • {{ $community->created_at->diffForHumans() }}
            </div>
            @auth
                @if(auth()->user()->subscribedCommunities->contains($community))
                    <form action="{{ route('communities.unsubscribe', $community) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300">Unsubscribe</button>
                    </form>
                @else
                    <form action="{{ route('communities.subscribe', $community) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-orange-600 text-white px-4 py-2 rounded hover:bg-orange-700">Subscribe</button>
                    </form>
                @endif
            @endauth
        </div>
    </div>
</div>
@endsection
