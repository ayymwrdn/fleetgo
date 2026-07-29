@extends('layouts.app')

@section('title', 'Activity Logs - FleetGo')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="card p-6">
        
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-600 dark:text-gray-300">
                <i class="fas fa-history text-lg"></i>
            </div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Activity Logs</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="text-left py-3 px-2 text-gray-500 dark:text-gray-400 font-medium">User</th>
                        <th class="text-left py-3 px-2 text-gray-500 dark:text-gray-400 font-medium">Aksi</th>
                        <th class="text-left py-3 px-2 text-gray-500 dark:text-gray-400 font-medium hidden md:table-cell">Deskripsi</th>
                        <th class="text-left py-3 px-2 text-gray-500 dark:text-gray-400 font-medium hidden sm:table-cell">Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs ?? [] as $log)
                    <tr class="border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                        <td class="py-3 px-2 font-medium text-gray-900 dark:text-white">{{ $log->user->name }}</td>
                        <td class="py-3 px-2">
                            <span class="badge 
                                @if($log->action == 'create_booking') badge-approved
                                @elseif($log->action == 'approve_booking') badge-pending-l1
                                @elseif($log->action == 'reject_booking') badge-rejected
                                @else badge-completed @endif">
                                {{ str_replace('_', ' ', $log->action) }}
                            </span>
                        </td>
                        <td class="py-3 px-2 hidden md:table-cell text-gray-600 dark:text-gray-400">{{ $log->description }}</td>
                        <td class="py-3 px-2 hidden sm:table-cell text-gray-500 dark:text-gray-400 text-xs">{{ $log->created_at->format('d M Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-8 text-gray-400 dark:text-gray-500">
                            <i class="fas fa-inbox text-2xl block mb-2"></i>
                            Belum ada aktivitas
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $logs->links() ?? '' }}
        </div>
    </div>
</div>
@endsection