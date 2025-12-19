@extends('layout')

@section('title', $post->title)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex">
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

                <span class="font-bold text-lg {{ $post->votes > 0 ? 'text-orange-600' : ($post->votes < 0 ? 'text-blue-600' : 'text-gray-600') }}">
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
                <div class="text-sm text-gray-600 mb-2">
                    <a href="{{ route('communities.show', $post->community) }}" class="font-bold hover:underline">r/{{ $post->community->name }}</a>
                    • Posted by <a href="{{ route('users.show', $post->user) }}" class="hover:underline">u/{{ $post->user->name }}</a>
                    • {{ $post->created_at->diffForHumans() }}
                </div>
                <h1 class="text-2xl font-bold mb-4">{{ $post->title }}</h1>
                @if($post->content)
                    <p class="text-gray-700 mb-4 whitespace-pre-wrap">{{ $post->content }}</p>
                @endif
                @if($post->url)
                    <a href="{{ $post->url }}" target="_blank" class="text-blue-600 hover:underline">{{ $post->url }}</a>
                @endif

                @auth
                    @if($post->user_id === auth()->id())
                        <form action="{{ route('posts.destroy', $post) }}" method="POST" class="mt-4">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Are you sure?')">Delete Post</button>
                        </form>
                    @endif
                @endauth
            </div>
        </div>
    </div>

    @auth
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-bold mb-4">Add a Comment</h2>
            <form action="{{ route('comments.store', $post) }}" method="POST">
                @csrf
                <textarea name="content" rows="4" required
                          class="w-full px-3 py-2 border rounded focus:outline-none focus:border-orange-500"></textarea>
                @error('content')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <button type="submit" class="mt-2 bg-orange-600 text-white px-4 py-2 rounded hover:bg-orange-700">
                    Comment
                </button>
            </form>
        </div>
    @endauth

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold mb-4">Comments ({{ $post->comments->count() }})</h2>

        @forelse($post->comments->whereNull('parent_id') as $comment)
            @include('partials.comment', ['comment' => $comment, 'depth' => 0])
        @empty
            <p class="text-gray-600">No comments yet. Be the first to comment!</p>
        @endforelse
    </div>
</div>
@endsection
