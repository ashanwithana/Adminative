@extends('layouts.app')

@section('title', 'Dashboard')

@section('header', 'Dashboard')

@section('breadcrumbs')
<li><a href="{{ route('admin.dashboard') }}" class="hover:text-gray-900">Dashboard</a></li>
@endsection

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Users -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Total Users</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['total_users'] }}</p>
            </div>
            <div class="p-3 bg-blue-100 rounded-full">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Active Users -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Active Users</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['active_users'] }}</p>
            </div>
            <div class="p-3 bg-green-100 rounded-full">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Total Roles -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Total Roles</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['total_roles'] }}</p>
            </div>
            <div class="p-3 bg-purple-100 rounded-full">
                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-sm text-gray-600 mb-4">Quick Actions</p>
        <div class="space-y-2">
            @can('create users')
            <a href="{{ route('admin.users.create') }}" class="block text-sm text-primary-600 hover:text-primary-800">
                + Add New User
            </a>
            @endcan
            @can('create roles')
            <a href="{{ route('admin.roles.create') }}" class="block text-sm text-primary-600 hover:text-primary-800">
                + Create Role
            </a>
            @endcan
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">Recent Activity</h3>
    </div>
    <div class="p-6">
        @if($stats['recent_activities']->count() > 0)
        <div class="space-y-4">
            @foreach($stats['recent_activities'] as $activity)
            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0 w-2 h-2 mt-2 bg-primary-600 rounded-full"></div>
                <div class="flex-1">
                    <p class="text-sm text-gray-900">
                        <span class="font-medium">{{ $activity->causer?->name ?? 'System' }}</span>
                        {{ $activity->description }}
                        @if($activity->subject)
                        <span class="text-gray-600">{{ class_basename($activity->subject_type) }} #{{ $activity->subject_id }}</span>
                        @endif
                    </p>
                    <p class="text-xs text-gray-500">{{ $activity->created_at->diffForHumans() }}</p>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-gray-500 text-center py-8">No recent activity</p>
        @endif
    </div>
</div>
@endsection