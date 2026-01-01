<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel Admin Panel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .mesh-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }
        @keyframes gradient {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .fade-in {
            animation: fadeIn 0.8s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="mesh-gradient min-h-screen">
    <!-- Navigation -->
    <nav class="absolute top-0 left-0 right-0 z-50 px-6 py-6">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <h1 class="text-2xl font-bold text-white">{{ config('app.name', 'Admin Panel') }}</h1>
            @if (Route::has('login'))
                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-6 py-2 text-white hover:bg-white/20 rounded-lg transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-6 py-2 text-white hover:bg-white/20 rounded-lg transition">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-6 py-2 bg-white text-purple-600 font-semibold rounded-lg hover:bg-gray-100 transition">Get Started</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="min-h-screen flex items-center justify-center px-6">
        <div class="max-w-6xl mx-auto text-center fade-in">
            <h2 class="text-5xl md:text-7xl font-bold text-white mb-6">
                Modern Admin Panel
            </h2>
            <p class="text-xl md:text-2xl text-white/90 mb-12 max-w-3xl mx-auto">
                A powerful Laravel admin panel with role-based access control, two-factor authentication, and comprehensive user management.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center mb-16">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-8 py-4 bg-white text-purple-600 font-semibold rounded-lg hover:bg-gray-100 transition text-lg">
                            Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-8 py-4 bg-white text-purple-600 font-semibold rounded-lg hover:bg-gray-100 transition text-lg">
                            Login
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-8 py-4 glass-card text-white font-semibold rounded-lg hover:bg-white/20 transition text-lg">
                                Register
                            </a>
                        @endif
                    @endauth
                @endif
            </div>

            <!-- Features Grid -->
            <div class="grid md:grid-cols-3 gap-6 mt-12">
                <div class="glass-card p-8 rounded-2xl text-left">
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">Two-Factor Auth</h3>
                    <p class="text-white/80">Secure your account with OTP-based two-factor authentication via email or SMS.</p>
                </div>

                <div class="glass-card p-8 rounded-2xl text-left">
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">Role Management</h3>
                    <p class="text-white/80">Dynamic role-based access control with granular permissions management.</p>
                </div>

                <div class="glass-card p-8 rounded-2xl text-left">
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">Activity Logs</h3>
                    <p class="text-white/80">Track all user activities and system changes with comprehensive logging.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>