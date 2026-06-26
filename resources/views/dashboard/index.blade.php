@extends('layouts.public')

@section('title', 'Dashboard')
@section('meta_description', 'Manage and track all your shipments from your Blue Orient Logistics dashboard.')

@section('content')

<section class="relative pt-28 pb-24 overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-blue-900/10 via-slate-950 to-slate-950"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-10">
            <div class="animate-fade-in-up">
                <h1 class="text-3xl font-bold text-white mb-2" style="font-family: 'Outfit', sans-serif;">
                    Welcome back, <span class="text-gradient">{{ Auth::user()->name }}</span>
                </h1>
                <p class="text-slate-400">Manage and track all your shipments</p>
            </div>
            <a href="{{ route('shipment.create') }}" class="btn-primary mt-4 md:mt-0 animate-fade-in-up delay-100" id="dashboard-send-btn">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                New Shipment
            </a>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-10 animate-fade-in-up delay-200">
            <div class="stat-card">
                <div class="text-2xl font-bold text-white mb-1">{{ $stats['total'] }}</div>
                <div class="text-sm text-slate-400">Total Shipments</div>
            </div>
            <div class="stat-card">
                <div class="text-2xl font-bold text-indigo-400 mb-1">{{ $stats['in_transit'] }}</div>
                <div class="text-sm text-slate-400">In Transit</div>
            </div>
            <div class="stat-card">
                <div class="text-2xl font-bold text-emerald-400 mb-1">{{ $stats['delivered'] }}</div>
                <div class="text-sm text-slate-400">Delivered</div>
            </div>
            <div class="stat-card">
                <div class="text-2xl font-bold text-yellow-400 mb-1">{{ $stats['pending'] }}</div>
                <div class="text-sm text-slate-400">Pending</div>
            </div>
        </div>

        {{-- Filters --}}
        <div class="glass-card p-4 mb-6 animate-fade-in-up delay-300">
            <form action="{{ route('dashboard') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by tracking number..."
                           class="form-input !py-2" id="dashboard-search">
                </div>
                <select name="status" class="form-select !py-2 sm:w-48" id="dashboard-status-filter">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="picked_up" {{ request('status') == 'picked_up' ? 'selected' : '' }}>Picked Up</option>
                    <option value="in_transit" {{ request('status') == 'in_transit' ? 'selected' : '' }}>In Transit</option>
                    <option value="out_for_delivery" {{ request('status') == 'out_for_delivery' ? 'selected' : '' }}>Out for Delivery</option>
                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                </select>
                <button type="submit" class="btn-primary btn-sm" id="dashboard-filter-btn">Filter</button>
            </form>
        </div>

        {{-- Shipments Table --}}
        <div class="glass-card overflow-hidden animate-fade-in-up delay-400">
            @if($shipments->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full" id="shipments-table">
                        <thead class="border-b border-white/5">
                            <tr>
                                <th class="table-header">{{ __('Track') }}ing #</th>
                                <th class="table-header">Receiver</th>
                                <th class="table-header">Type</th>
                                <th class="table-header">Status</th>
                                <th class="table-header">Date</th>
                                <th class="table-header">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @foreach($shipments as $shipment)
                                <tr class="hover:bg-white/5 transition-colors">
                                    <td class="table-cell">
                                        <span class="font-mono text-blue-400">{{ $shipment->tracking_number }}</span>
                                    </td>
                                    <td class="table-cell">{{ $shipment->receiver_name }}</td>
                                    <td class="table-cell capitalize">{{ $shipment->package_type }}</td>
                                    <td class="table-cell">
                                        <span class="badge badge-{{ $shipment->status }}">
                                            <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                            {{ $shipment->status_label }}
                                        </span>
                                    </td>
                                    <td class="table-cell text-slate-500">{{ $shipment->created_at->format('M d, Y') }}</td>
                                    <td class="table-cell">
                                        <div class="flex gap-2">
                                            <a href="{{ route('dashboard.shipment', $shipment->id) }}" class="text-blue-400 hover:text-blue-300 text-sm font-medium transition-colors">View</a>
                                            <a href="{{ route('track.result', $shipment->tracking_number) }}" class="text-emerald-400 hover:text-emerald-300 text-sm font-medium transition-colors">{{ __('Track') }}</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($shipments->hasPages())
                    <div class="px-6 py-4 border-t border-white/5">
                        {{ $shipments->withQueryString()->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-16">
                    <div class="w-16 h-16 bg-white/5 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    <h3 class="text-lg font-medium text-white mb-2">No shipments yet</h3>
                    <p class="text-slate-400 text-sm mb-6">Create your first shipment to get started.</p>
                    <a href="{{ route('shipment.create') }}" class="btn-primary btn-sm">{{ __('Create Shipment') }}</a>
                </div>
            @endif
        </div>
    </div>
</section>

@endsection
