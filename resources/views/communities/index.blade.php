@extends('layout')

@section('title', 'Communities')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Communities</h1>
        @auth
            <a href="{{ route('communities.create') }}" class="bg-orange-600 text-white px-4 py-2 rounded hover:bg-orange-700">Create Community</a>
        @endauth
    </div>

    @forelse($communities as $community)
        <div class="bg-white rounded-lg shadow mb-4 p-6">
            <h2 class="text-2xl font-bold mb-2">
                <a href="{{ route('communities.show', $community) }}" class="hover:text-orange-600">r/{{ $community->name }}</a>
            </h2>
            @if($community->description)
                <p class="text-gray-700 mb-3">{{ $community->description }}</p>
            @endif
            <div class="text-sm text-gray-600">
                {{ $community->posts_count }} posts • {{ $community->subscribers_count }} subscribers
                • Created {{ $community->created_at->diffForHumans() }}
            </div>
        </div>
    @empty
        <p class="text-gray-600">No communities yet. Be the first to create one!</p>
    @endforelse

    <div class="mt-4">
        {{ $communities->links() }}
    </div>
</div>
@endsection
