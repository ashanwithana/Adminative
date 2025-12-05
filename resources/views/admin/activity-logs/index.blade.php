@extends('layouts.app')

@section('title', 'Activity Logs')

@section('header', 'Activity Logs')

@section('breadcrumbs')
<li><a href="{{ route('admin.dashboard') }}" class="hover:text-gray-900">Dashboard</a></li>
<li class="text-gray-400">/</li>
<li>Activity Logs</li>
@endsection

@section('content')
<div class="bg-white rounded-lg shadow">
    <!-- Header with Filters -->
    <div class="px-6 py-4 border-b border-gray-200">
        <form method="GET" class="flex items-center space-x-4">
            <input type="text"
                name="description"
                value="{{ request('description') }}"
                placeholder="Search description..."
                class="rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 px-4 py-2 border">

            <input type="date"
                name="date"
                value="{{ request('date') }}"
                class="rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 px-4 py-2 border">

            <button type="submit" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                Filter
            </button>

            @if(request()->hasAny(['description', 'date', 'causer_id']))
            <a href="{{ route('admin.activity-logs.index') }}" class="px-4 py-2 text-gray-600 hover:text-gray-900">
                Clear
            </a>
            @endif
        </form>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($activities as $activity)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">
                            {{ $activity->causer?->name ?? 'System' }}
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ $activity->causer?->email ?? '-' }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ $activity->description }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($activity->subject)
                        <div class="text-sm text-gray-900">
                            {{ class_basename($activity->subject_type) }} #{{ $activity->subject_id }}
                        </div>
                        @else
                        <span class="text-sm text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $activity->created_at->format('M d, Y H:i:s') }}
                        <div class="text-xs text-gray-400">{{ $activity->created_at->diffForHumans() }}</div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">No activity logs found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $activities->links() }}
    </div>
</div>
@endsection