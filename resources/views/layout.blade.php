<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Reddit Clone')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-orange-600">Reddit Clone</a>
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-gray-900">Home</a>
                    <a href="{{ route('communities.index') }}" class="text-gray-700 hover:text-gray-900">Communities</a>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('posts.create') }}" class="bg-orange-600 text-white px-4 py-2 rounded hover:bg-orange-700">Create Post</a>
                        <a href="{{ route('communities.create') }}" class="text-gray-700 hover:text-gray-900">Create Community</a>
                        <a href="{{ route('users.show', auth()->user()) }}" class="text-gray-700 hover:text-gray-900">{{ auth()->user()->name }} ({{ auth()->user()->karma }})</a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-gray-900">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900">Login</a>
                        <a href="{{ route('register') }}" class="bg-orange-600 text-white px-4 py-2 rounded hover:bg-orange-700">Sign Up</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>
</body>
</html>
