@extends('layout')

@section('title', 'u/' . $user->name)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h1 class="text-3xl font-bold mb-2">u/{{ $user->name }}</h1>
        <div class="text-gray-600">
            <p>Karma: {{ $user->karma }}</p>
            <p>Joined {{ $user->created_at->diffForHumans() }}</p>
        </div>
    </div>

    <div class="mb-6">
        <h2 class="text-2xl font-bold mb-4">Posts</h2>
        @forelse($posts as $post)
            <div class="bg-white rounded-lg shadow mb-4 p-4">
                <h3 class="text-xl font-semibold mb-2">
                    <a href="{{ route('posts.show', $post) }}" class="hover:text-orange-600">{{ $post->title }}</a>
                </h3>
                <div class="text-sm text-gray-600">
                    <a href="{{ route('communities.show', $post->community) }}" class="font-bold hover:underline">r/{{ $post->community->name }}</a>
                    • {{ $post->votes }} votes
                    • {{ $post->comments->count() }} comments
                    • {{ $post->created_at->diffForHumans() }}
                </div>
            </div>
        @empty
            <p class="text-gray-600">No posts yet.</p>
        @endforelse
        <div class="mt-4">
            {{ $posts->links() }}
        </div>
    </div>

    <div>
        <h2 class="text-2xl font-bold mb-4">Comments</h2>
        @forelse($comments as $comment)
            <div class="bg-white rounded-lg shadow mb-4 p-4">
                <p class="text-gray-700 mb-2">{{ Str::limit($comment->content, 200) }}</p>
                <div class="text-sm text-gray-600">
                    On <a href="{{ route('posts.show', $comment->post) }}" class="hover:underline">{{ $comment->post->title }}</a>
                    in <a href="{{ route('communities.show', $comment->post->community) }}" class="font-bold hover:underline">r/{{ $comment->post->community->name }}</a>
                    • {{ $comment->votes }} votes
                    • {{ $comment->created_at->diffForHumans() }}
                </div>
            </div>
        @empty
            <p class="text-gray-600">No comments yet.</p>
        @endforelse
        <div class="mt-4">
            {{ $comments->links() }}
        </div>
    </div>
</div>
@endsection
