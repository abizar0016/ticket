@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6 flex items-center gap-2">
        <i class="ri-history-line text-indigo-500 text-3xl"></i>
        Log Activity
    </h1>

    <!-- Search -->
    <form method="GET" action="{{ route('superAdmin.activities') }}" class="mb-6">
        <input type="text" name="search" placeholder="Cari aktivitas..."
               value="{{ request('search') }}"
               class="w-full sm:w-80 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
    </form>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th class="py-3 px-4 text-gray-600 dark:text-gray-300">User</th>
                    <th class="py-3 px-4 text-gray-600 dark:text-gray-300">Aksi</th>
                    <th class="py-3 px-4 text-gray-600 dark:text-gray-300">Waktu</th>
                    <th class="py-3 px-4 text-gray-600 dark:text-gray-300">Detail</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($activities as $activity)
                    <tr class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                        <td class="py-3 px-4">
                            <div class="flex items-center gap-2">
                                <i class="ri-user-line text-indigo-500"></i>
                                <span class="text-gray-800 dark:text-gray-100">
                                    {{ $activity->user->name ?? 'Unknown User' }}
                                </span>
                            </div>
                        </td>
                        <td class="py-3 px-4 text-gray-700 dark:text-gray-300">
                            {{ $activity->action }}
                        </td>
                        <td class="py-3 px-4 text-gray-600 dark:text-gray-400">
                            {{ $activity->created_at->diffForHumans() }}
                        </td>
                        <td class="py-3 px-4">
                            @if ($activity->link)
                                <a href="{{ $activity->link }}"
                                   class="inline-flex items-center gap-1 text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 transition">
                                   <i class="ri-external-link-line"></i> Lihat
                                </a>
                            @else
                                <span class="text-gray-400 italic">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-6 text-center text-gray-500 dark:text-gray-400">
                            Belum ada aktivitas tercatat.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $activities->links() }}
    </div>
</div>
@endsection
