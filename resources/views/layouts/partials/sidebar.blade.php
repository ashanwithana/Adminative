<aside class="w-64 bg-gray-800 text-white flex flex-col">
    <!-- Logo -->
    <div class="p-6 border-b border-gray-700">
        <h1 class="text-2xl font-bold">Admin Panel</h1>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto p-4">
        <ul class="space-y-2">
            <!-- Dashboard -->
            <li>
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-4 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>
            </li>

            <!-- Users -->
            @can('view users')
            <li>
                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center px-4 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.users.*') ? 'bg-gray-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Users
                </a>
            </li>
            @endcan

            <!-- Roles -->
            @can('view roles')
            <li>
                <a href="{{ route('admin.roles.index') }}"
                    class="flex items-center px-4 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.roles.*') ? 'bg-gray-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    Roles
                </a>
            </li>
            @endcan

            <!-- Activity Logs -->
            @can('view activity logs')
            <li>
                <a href="{{ route('admin.activity-logs.index') }}"
                    class="flex items-center px-4 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.activity-logs.*') ? 'bg-gray-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Activity Logs
                </a>
            </li>
            @endcan

            <!-- System -->
            @can('access telescope')
            <li class="pt-4 mt-4 border-t border-gray-700">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">System</p>
            </li>
            <li>
                <a href="/telescope" target="_blank"
                    class="flex items-center px-4 py-2 rounded hover:bg-gray-700">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                    Telescope
                </a>
            </li>
            @endcan
        </ul>
    </nav>

    <!-- User Info -->
    <div class="p-4 border-t border-gray-700">
        <div class="flex items-center">
            <div class="flex-shrink-0 w-10 h-10 bg-gray-600 rounded-full flex items-center justify-center">
                <span class="text-sm font-medium">{{ substr(auth()->user()->name, 0, 2) }}</span>
            </div>
            <div class="ml-3 flex-1">
                <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-400">{{ auth()->user()->roles->first()?->name ?? 'User' }}</p>
            </div>
        </div>
    </div>
</aside>