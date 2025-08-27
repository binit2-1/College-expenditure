<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'College Expenditure System')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Simple Header -->
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <h1 class="text-xl font-semibold text-gray-900">College Expenditure System</h1>
                
                <!-- Navigation -->
                <div class="flex items-center space-x-8">
                    <div class="flex space-x-8">
                        <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-blue-600 transition-colors">Dashboard</a>
                        <a href="{{ route('expenditures.index') }}" class="text-gray-700 hover:text-blue-600 transition-colors">Expenditures</a>
                        @auth
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('uc.index') }}" class="text-gray-700 hover:text-blue-600 transition-colors">UC Generator</a>
                            @endif
                        @endauth
                        <a href="{{ route('reports.index') }}" class="text-gray-700 hover:text-blue-600 transition-colors">Reports</a>
                        <a href="{{ route('guide') }}" class="text-gray-700 hover:text-blue-600 transition-colors">How to Use</a>
                    </div>
                    
                    @auth
                        <div class="flex items-center space-x-4">
                            <div class="text-sm text-gray-600">
                                <span class="font-medium">{{ auth()->user()->name }}</span>
                                <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded ml-2">{{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}</span>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-gray-500 hover:text-gray-700 transition-colors">
                                    Logout
                                </button>
                            </form>
                        </div>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <button class="md:hidden">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
