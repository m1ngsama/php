@extends('layout')

@section('title', 'Home')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <h1 class="text-3xl font-bold mb-6">Popular Posts</h1>

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
                        <a href="{{ route('communities.show', $post->community) }}" class="font-bold hover:underline">r/{{ $post->community->name }}</a>
                        • Posted by <a href="{{ route('users.show', $post->user) }}" class="hover:underline">u/{{ $post->user->name }}</a>
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
            <p class="text-gray-600">No posts yet. Be the first to create one!</p>
        @endforelse

        <div class="mt-4">
            {{ $posts->links() }}
        </div>
    </div>

    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow p-4">
            <h2 class="text-xl font-bold mb-4">About</h2>
            <p class="text-gray-700 mb-4">Welcome to our Reddit-like community forum! Share your thoughts, engage in discussions, and connect with others.</p>
            @auth
                <a href="{{ route('posts.create') }}" class="block w-full text-center bg-orange-600 text-white px-4 py-2 rounded hover:bg-orange-700">Create Post</a>
            @else
                <a href="{{ route('register') }}" class="block w-full text-center bg-orange-600 text-white px-4 py-2 rounded hover:bg-orange-700">Sign Up</a>
            @endauth
        </div>
    </div>
</div>
@endsection
