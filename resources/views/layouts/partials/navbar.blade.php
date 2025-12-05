<header class="bg-white shadow-sm">
    <div class="px-6 py-4 flex items-center justify-between">
        <div class="flex-1">
            <!-- Can be used for search or other elements -->
        </div>

        <div class="flex items-center space-x-4">
            <!-- User Dropdown -->
            <div class="relative">
                <form action="{{ route('auth.logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="flex items-center text-gray-700 hover:text-gray-900">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>