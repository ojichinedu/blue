@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page_title', 'Dashboard')

@section('content')

{{-- Stats Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="stat-card">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <span class="text-xs text-slate-500">Total</span>
        </div>
        <div class="text-3xl font-bold text-white">{{ $stats['total_shipments'] }}</div>
        <div class="text-sm text-slate-400 mt-1">Total Shipments</div>
    </div>

    <div class="stat-card">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-indigo-500/20 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
            </div>
            <span class="text-xs text-slate-500">Active</span>
        </div>
        <div class="text-3xl font-bold text-indigo-400">{{ $stats['in_transit'] }}</div>
        <div class="text-sm text-slate-400 mt-1">In Transit</div>
    </div>

    <div class="stat-card">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-emerald-500/20 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <span class="text-xs text-slate-500">Today</span>
        </div>
        <div class="text-3xl font-bold text-emerald-400">{{ $stats['delivered_today'] }}</div>
        <div class="text-sm text-slate-400 mt-1">Delivered Today</div>
    </div>

    <div class="stat-card">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-yellow-500/20 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <span class="text-xs text-slate-500">Awaiting</span>
        </div>
        <div class="text-3xl font-bold text-yellow-400">{{ $stats['pending'] }}</div>
        <div class="text-sm text-slate-400 mt-1">Pending Pickup</div>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-8">
    {{-- Recent Shipments --}}
    <div class="lg:col-span-2">
        <div class="glass-card overflow-hidden">
            <div class="px-6 py-4 border-b border-white/5 flex items-center justify-between">
                <h2 class="text-sm font-semibold text-white">Recent Shipments</h2>
                <a href="{{ route('admin.shipments') }}" class="text-blue-400 text-xs hover:text-blue-300 transition-colors">View All →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="border-b border-white/5">
                        <tr>
                            <th class="table-header">{{ __('Track') }}ing #</th>
                            <th class="table-header">Sender</th>
                            <th class="table-header">Status</th>
                            <th class="table-header">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($recentShipments as $shipment)
                            <tr class="hover:bg-white/5 transition-colors cursor-pointer" onclick="window.location='{{ route('admin.shipment.show', $shipment->id) }}'">
                                <td class="table-cell"><span class="font-mono text-blue-400 text-xs">{{ $shipment->tracking_number }}</span></td>
                                <td class="table-cell text-xs">{{ $shipment->sender_name }}</td>
                                <td class="table-cell">
                                    <span class="badge badge-{{ $shipment->status }} text-[10px]">{{ $shipment->status_label }}</span>
                                </td>
                                <td class="table-cell text-xs text-slate-500">{{ $shipment->created_at->format('M d') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="table-cell text-center text-slate-500 py-8">No shipments yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Status Distribution --}}
    <div>
        <div class="glass-card p-6">
            <h2 class="text-sm font-semibold text-white mb-6">Status Distribution</h2>
            <div class="space-y-4">
                @php
                    $total = max(array_sum($statusCounts), 1);
                    $colors = [
                        'pending' => ['bg-yellow-500', 'text-yellow-300'],
                        'picked_up' => ['bg-blue-500', 'text-blue-300'],
                        'in_transit' => ['bg-indigo-500', 'text-indigo-300'],
                        'out_for_delivery' => ['bg-orange-500', 'text-orange-300'],
                        'delivered' => ['bg-emerald-500', 'text-emerald-300'],
                        'cancelled' => ['bg-red-500', 'text-red-300'],
                    ];
                @endphp
                @foreach($statusCounts as $status => $count)
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-xs {{ $colors[$status][1] ?? 'text-slate-300' }} capitalize">{{ str_replace('_', ' ', $status) }}</span>
                            <span class="text-xs text-slate-500">{{ $count }}</span>
                        </div>
                        <div class="w-full h-2 bg-white/5 rounded-full overflow-hidden">
                            <div class="{{ $colors[$status][0] ?? 'bg-slate-500' }} h-full rounded-full transition-all duration-1000" style="width: {{ ($count / $total) * 100 }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="glass-card p-6 mt-6">
            <h2 class="text-sm font-semibold text-white mb-4">Quick Actions</h2>
            <div class="space-y-2">
                <a href="{{ route('admin.shipments') }}?status=pending" class="admin-nav-link text-yellow-400">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    View Pending ({{ $stats['pending'] }})
                </a>
                <a href="{{ route('admin.shipments') }}?status=in_transit" class="admin-nav-link text-indigo-400">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    View In Transit ({{ $stats['in_transit'] }})
                </a>
                <a href="{{ route('home') }}" target="_blank" class="admin-nav-link">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    View Public Site
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
