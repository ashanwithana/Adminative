<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel Admin') }} - @yield('title', 'Dashboard')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        @include('layouts.partials.sidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Navbar -->
            @include('layouts.partials.navbar')

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                <!-- Breadcrumbs -->
                @if (isset($breadcrumbs) || View::hasSection('breadcrumbs'))
                <nav class="mb-4">
                    <ol class="flex items-center space-x-2 text-sm text-gray-600">
                        @yield('breadcrumbs')
                    </ol>
                </nav>
                @endif

                <!-- Flash Messages -->
                @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
                @endif

                @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ session('error') }}
                </div>
                @endif

                <!-- Page Heading -->
                @if (isset($header) || View::hasSection('header'))
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-gray-800">
                        @yield('header')
                    </h1>
                </div>
                @endif

                <!-- Main Content Area -->
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>

</html>