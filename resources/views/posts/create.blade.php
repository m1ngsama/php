@extends('layout')

@section('title', 'Create Post')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-lg shadow p-8">
    <h1 class="text-2xl font-bold mb-6">Create a Post</h1>

    <form action="{{ route('posts.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="community_id" class="block text-gray-700 font-bold mb-2">Community</label>
            <select id="community_id" name="community_id" required
                    class="w-full px-3 py-2 border rounded focus:outline-none focus:border-orange-500">
                <option value="">Select a community</option>
                @foreach($communities as $community)
                    <option value="{{ $community->id }}" {{ old('community_id') == $community->id ? 'selected' : '' }}>
                        r/{{ $community->name }}
                    </option>
                @endforeach
            </select>
            @error('community_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="type" class="block text-gray-700 font-bold mb-2">Post Type</label>
            <select id="type" name="type" required
                    class="w-full px-3 py-2 border rounded focus:outline-none focus:border-orange-500">
                <option value="text" {{ old('type') == 'text' ? 'selected' : '' }}>Text</option>
                <option value="link" {{ old('type') == 'link' ? 'selected' : '' }}>Link</option>
                <option value="image" {{ old('type') == 'image' ? 'selected' : '' }}>Image</option>
            </select>
            @error('type')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="title" class="block text-gray-700 font-bold mb-2">Title</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" required
                   class="w-full px-3 py-2 border rounded focus:outline-none focus:border-orange-500">
            @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4" id="content-field">
            <label for="content" class="block text-gray-700 font-bold mb-2">Content</label>
            <textarea id="content" name="content" rows="6"
                      class="w-full px-3 py-2 border rounded focus:outline-none focus:border-orange-500">{{ old('content') }}</textarea>
            @error('content')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6 hidden" id="url-field">
            <label for="url" class="block text-gray-700 font-bold mb-2">URL</label>
            <input type="url" id="url" name="url" value="{{ old('url') }}"
                   class="w-full px-3 py-2 border rounded focus:outline-none focus:border-orange-500">
            @error('url')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="bg-orange-600 text-white px-6 py-2 rounded hover:bg-orange-700 font-bold">
            Create Post
        </button>
    </form>
</div>

<script>
    document.getElementById('type').addEventListener('change', function() {
        const contentField = document.getElementById('content-field');
        const urlField = document.getElementById('url-field');

        if (this.value === 'text') {
            contentField.classList.remove('hidden');
            urlField.classList.add('hidden');
        } else {
            contentField.classList.add('hidden');
            urlField.classList.remove('hidden');
        }
    });
</script>
@endsection
