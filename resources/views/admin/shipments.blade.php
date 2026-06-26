@extends('layouts.admin')

@section('title', 'Manage Shipments')
@section('page_title', 'Shipments')

@section('content')

{{-- Filters --}}
<div class="glass-card p-4 mb-6">
    <form action="{{ route('admin.shipments') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
        <div class="flex-1">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search tracking #, sender, or receiver..."
                   class="form-input !py-2" id="admin-search">
        </div>
        <select name="status" class="form-select !py-2 sm:w-48" id="admin-status-filter">
            <option value="">All Statuses</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="picked_up" {{ request('status') == 'picked_up' ? 'selected' : '' }}>Picked Up</option>
            <option value="in_transit" {{ request('status') == 'in_transit' ? 'selected' : '' }}>In Transit</option>
            <option value="out_for_delivery" {{ request('status') == 'out_for_delivery' ? 'selected' : '' }}>Out for Delivery</option>
            <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
        <button type="submit" class="btn-primary btn-sm" id="admin-filter-btn">Filter</button>
        @if(request()->hasAny(['search', 'status']))
            <a href="{{ route('admin.shipments') }}" class="btn-secondary btn-sm">Clear</a>
        @endif
    </form>
</div>

{{-- Shipments Table --}}
<div class="glass-card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full" id="admin-shipments-table">
            <thead class="border-b border-white/5">
                <tr>
                    <th class="table-header">{{ __('Track') }}ing #</th>
                    <th class="table-header">Sender</th>
                    <th class="table-header">Receiver</th>
                    <th class="table-header">Type</th>
                    <th class="table-header">Status</th>
                    <th class="table-header">User</th>
                    <th class="table-header">Created</th>
                    <th class="table-header">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($shipments as $shipment)
                    <tr class="hover:bg-white/5 transition-colors">
                        <td class="table-cell"><span class="font-mono text-blue-400 text-xs">{{ $shipment->tracking_number }}</span></td>
                        <td class="table-cell text-sm">{{ $shipment->sender_name }}</td>
                        <td class="table-cell text-sm">{{ $shipment->receiver_name }}</td>
                        <td class="table-cell text-sm capitalize">{{ $shipment->package_type }}</td>
                        <td class="table-cell">
                            <span class="badge badge-{{ $shipment->status }} text-[10px]">
                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                {{ $shipment->status_label }}
                            </span>
                        </td>
                        <td class="table-cell text-sm text-slate-500">{{ $shipment->user?->name ?? 'Guest' }}</td>
                        <td class="table-cell text-sm text-slate-500">{{ $shipment->created_at->format('M d, Y') }}</td>
                        <td class="table-cell">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.shipment.show', $shipment->id) }}" class="text-blue-400 hover:text-blue-300 text-sm font-medium transition-colors">{{ __('Manage') }}</a>
                                <form action="{{ route('admin.shipment.destroy', $shipment->id) }}" method="POST" id="delete-form-{{ $shipment->id }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        onclick="if(confirm('Delete shipment {{ $shipment->tracking_number }}? This cannot be undone.')) { document.getElementById('delete-form-{{ $shipment->id }}').submit(); }"
                                        class="text-red-400 hover:text-red-300 text-sm font-medium transition-colors">{{ __('Delete') }}</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="table-cell text-center text-slate-500 py-12">No shipments found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($shipments->hasPages())
        <div class="px-6 py-4 border-t border-white/5">
            {{ $shipments->withQueryString()->links() }}
        </div>
    @endif
</div>

@endsection
