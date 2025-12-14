@extends('layout')

@section('title', 'Login')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-lg shadow p-8">
    <h1 class="text-2xl font-bold mb-6">Login</h1>

    <form action="{{ route('login') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-bold mb-2">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                   class="w-full px-3 py-2 border rounded focus:outline-none focus:border-orange-500">
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="block text-gray-700 font-bold mb-2">Password</label>
            <input type="password" id="password" name="password" required
                   class="w-full px-3 py-2 border rounded focus:outline-none focus:border-orange-500">
            @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="flex items-center">
                <input type="checkbox" name="remember" class="mr-2">
                <span class="text-gray-700">Remember me</span>
            </label>
        </div>

        <button type="submit" class="w-full bg-orange-600 text-white py-2 rounded hover:bg-orange-700 font-bold">
            Login
        </button>
    </form>

    <p class="mt-4 text-center text-gray-600">
        Don't have an account? <a href="{{ route('register') }}" class="text-orange-600 hover:underline">Sign up</a>
    </p>
</div>
@endsection
