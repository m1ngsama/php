@extends('layout')

@section('title', 'Create Community')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-lg shadow p-8">
    <h1 class="text-2xl font-bold mb-6">Create a Community</h1>

    <form action="{{ route('communities.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-bold mb-2">Name</label>
            <div class="flex items-center">
                <span class="text-gray-700 mr-2">r/</span>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                       class="flex-1 px-3 py-2 border rounded focus:outline-none focus:border-orange-500">
            </div>
            <p class="text-sm text-gray-600 mt-1">Community names cannot be changed</p>
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="description" class="block text-gray-700 font-bold mb-2">Description</label>
            <textarea id="description" name="description" rows="4"
                      class="w-full px-3 py-2 border rounded focus:outline-none focus:border-orange-500">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="bg-orange-600 text-white px-6 py-2 rounded hover:bg-orange-700 font-bold">
            Create Community
        </button>
    </form>
</div>
@endsection
