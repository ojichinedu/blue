@extends('layouts.admin')

@section('title', 'Shipment ' . $shipment->tracking_number)
@section('page_title', 'Shipment Details')

@section('header_actions')
    <a href="{{ route('admin.shipment.edit', $shipment->id) }}" class="btn-secondary btn-sm flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
        </svg>
        Edit Details
    </a>
    <a href="{{ route('track.result', $shipment->tracking_number) }}" target="_blank" class="btn-secondary btn-sm" id="admin-view-tracking">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
        {{ __('Public Tracker') }}
    </a>
    <form action="{{ route('admin.shipment.destroy', $shipment->id) }}" method="POST" id="delete-shipment-form" class="inline">
        @csrf
        @method('DELETE')
        <button type="button" class="btn-secondary btn-sm !text-red-400 !border-red-500/20 hover:!bg-red-500/10 transition-colors" id="admin-delete-shipment"
            onclick="if(confirm('Are you sure you want to delete this shipment? This cannot be undone.')) { document.getElementById('delete-shipment-form').submit(); }">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            {{ __('Delete') }}
        </button>
    </form>
@endsection

@section('content')

{{-- Back --}}
<a href="{{ route('admin.shipments') }}" class="inline-flex items-center gap-2 text-slate-400 hover:text-white mb-6 transition-colors text-sm">
    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    Back to Shipments
</a>

{{-- Header --}}
<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
    <div>
        <div class="flex items-center gap-3 mb-2">
            <h2 class="text-2xl font-bold text-white" style="font-family: 'Outfit', sans-serif;">{{ $shipment->tracking_number }}</h2>
            <span class="badge badge-{{ $shipment->status }}">
                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                {{ $shipment->status_label }}
            </span>
        </div>
        <p class="text-sm text-slate-400">{{ $shipment->sender_name }} → {{ $shipment->receiver_name }} · Created {{ $shipment->created_at->format('M d, Y H:i') }}</p>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-8">
    {{-- Left Column --}}
    <div class="lg:col-span-2 space-y-6">

        {{-- Update Status & Position --}}
        <div class="glass-card p-6">
            <h3 class="text-sm font-semibold text-white mb-6 flex items-center gap-2">
                <svg class="w-4 h-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Update Shipment
            </h3>
            <form action="{{ route('admin.shipment.update', $shipment->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid md:grid-cols-3 gap-4">
                    <div>
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" id="admin-update-status">
                            <option value="pending" {{ $shipment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="picked_up" {{ $shipment->status == 'picked_up' ? 'selected' : '' }}>Picked Up</option>
                            <option value="in_transit" {{ $shipment->status == 'in_transit' ? 'selected' : '' }}>In Transit</option>
                            <option value="out_for_delivery" {{ $shipment->status == 'out_for_delivery' ? 'selected' : '' }}>Out for Delivery</option>
                            <option value="delivered" {{ $shipment->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $shipment->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Current Latitude</label>
                        <input type="number" name="current_lat" value="{{ $shipment->current_lat }}" class="form-input" step="0.0000001" id="admin-lat">
                    </div>
                    <div>
                        <label class="form-label">Current Longitude</label>
                        <input type="number" name="current_lng" value="{{ $shipment->current_lng }}" class="form-input" step="0.0000001" id="admin-lng">
                    </div>
                    <div class="md:col-span-3">
                        <label class="form-label">Note / Description</label>
                        <input type="text" name="note" class="form-input" placeholder="e.g. Package arrived at regional sorting facility (Optional)" id="admin-update-note">
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn-primary btn-sm" id="admin-update-btn">Update Shipment</button>
                </div>
            </form>
        </div>

        {{-- Map with Draggable Marker --}}
        <div class="glass-card overflow-hidden">
            <div class="px-6 py-4 border-b border-white/5">
                <h3 class="text-sm font-semibold text-white">Map — Drag marker to update position</h3>
            </div>
            <div id="admin-map" style="height: 400px; z-index: 1;"></div>
        </div>

        {{-- Add {{ __('Track') }}ing Update --}}
        <div class="glass-card p-6">
            <h3 class="text-sm font-semibold text-white mb-6 flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add {{ __('Track') }}ing Update
            </h3>
            <form action="{{ route('admin.shipment.addUpdate', $shipment->id) }}" method="POST">
                @csrf
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" id="update-status">
                            <option value="pending">Pending</option>
                            <option value="picked_up">Picked Up</option>
                            <option value="in_transit" selected>In Transit</option>
                            <option value="out_for_delivery">Out for Delivery</option>
                            <option value="delivered">Delivered</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Location Name *</label>
                        <input type="text" name="location_name" class="form-input" required placeholder="e.g. Chicago Distribution Center" id="update-location">
                    </div>
                    <div class="md:col-span-2">
                        <label class="form-label">Description</label>
                        <input type="text" name="description" class="form-input" placeholder="e.g. Package processed and dispatched" id="update-desc">
                    </div>
                    <div>
                        <label class="form-label">Latitude</label>
                        <input type="number" name="lat" class="form-input" step="0.0000001" placeholder="41.8781" id="update-lat">
                    </div>
                    <div>
                        <label class="form-label">Longitude</label>
                        <input type="number" name="lng" class="form-input" step="0.0000001" placeholder="-87.6298" id="update-lng">
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn-primary btn-sm" id="add-update-btn">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Add Update
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Right Column --}}
    <div class="space-y-6">
        {{-- Billing & Receipt --}}
        <div class="glass-card p-6 border-blue-500/20 bg-gradient-to-br from-slate-900/50 to-blue-950/10">
            <h3 class="text-xs font-semibold text-blue-400 uppercase tracking-wider mb-4 flex items-center justify-between">
                <span>Billing & Receipt</span>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </h3>
            
            @if($shipment->receipt)
                <div class="space-y-3 text-sm mb-6">
                    <div class="flex justify-between"><span class="text-slate-400">Receipt #</span><span class="text-white font-mono font-medium">{{ $shipment->receipt->receipt_number }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-400">Amount</span><span class="text-emerald-400 font-semibold">${{ number_format($shipment->receipt->amount, 2) }} USD</span></div>
                    <div class="flex justify-between"><span class="text-slate-400">Method</span><span class="text-white capitalize">{{ str_replace('_', ' ', $shipment->receipt->payment_method) }}</span></div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Status</span>
                        <span class="badge badge-{{ $shipment->receipt->payment_status === 'paid' ? 'delivered' : ($shipment->receipt->payment_status === 'pending' ? 'pending' : 'cancelled') }}">
                            <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                            {{ ucfirst($shipment->receipt->payment_status) }}
                        </span>
                    </div>
                    @if($shipment->receipt->notes)
                        <div class="pt-2 border-t border-white/5">
                            <span class="block text-xs text-slate-500 mb-1">Notes:</span>
                            <p class="text-xs text-slate-400 leading-relaxed italic">"{{ $shipment->receipt->notes }}"</p>
                        </div>
                    @endif
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('admin.receipt.show', $shipment->receipt->id) }}" target="_blank" class="btn-primary btn-sm flex items-center justify-center gap-1.5 !py-2.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        Print/PDF
                    </a>
                    <a href="{{ route('admin.receipt.edit', $shipment->receipt->id) }}" class="btn-secondary btn-sm flex items-center justify-center gap-1.5 !py-2.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        Edit
                    </a>
                    <form action="{{ route('admin.receipt.destroy', $shipment->receipt->id) }}" method="POST" class="col-span-2 mt-1" id="delete-receipt-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full btn-secondary btn-sm !text-red-400 !border-red-500/20 hover:!bg-red-500/10 transition-colors flex items-center justify-center gap-1.5" onclick="return confirm('Are you sure you want to delete this receipt?')">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            Delete Receipt
                        </button>
                    </form>
                </div>
            @else
                <p class="text-sm text-slate-400 mb-4">No receipt has been generated for this shipment yet.</p>
                <a href="{{ route('admin.receipt.create', $shipment->id) }}" class="w-full btn-primary btn-sm flex items-center justify-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Create Receipt
                </a>
            @endif
        </div>

        {{-- Shipment Info --}}
        <div class="glass-card p-6">
            <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-4">Sender</h3>
            <p class="text-white font-medium text-sm">{{ $shipment->sender_name }}</p>
            <p class="text-xs text-slate-400 mt-1">{{ $shipment->sender_email }}</p>
            <p class="text-xs text-slate-400">{{ $shipment->sender_phone }}</p>
            <p class="text-xs text-slate-400 mt-2">{{ $shipment->sender_address }}</p>
        </div>

        <div class="glass-card p-6">
            <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-4">Receiver</h3>
            <p class="text-white font-medium text-sm">{{ $shipment->receiver_name }}</p>
            <p class="text-xs text-slate-400 mt-1">{{ $shipment->receiver_email }}</p>
            <p class="text-xs text-slate-400">{{ $shipment->receiver_phone }}</p>
            <p class="text-xs text-slate-400 mt-2">{{ $shipment->receiver_address }}</p>
        </div>

        <div class="glass-card p-6">
            <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-4">Package</h3>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between"><span class="text-slate-400">Type</span><span class="text-white capitalize">{{ $shipment->package_type }}</span></div>
                @if($shipment->weight)<div class="flex justify-between"><span class="text-slate-400">Weight</span><span class="text-white">{{ $shipment->weight }} kg</span></div>@endif
                @if($shipment->package_description)<div class="flex justify-between"><span class="text-slate-400">Description</span><span class="text-white">{{ $shipment->package_description }}</span></div>@endif
                @if($shipment->estimated_delivery)<div class="flex justify-between"><span class="text-slate-400">Est. Delivery</span><span class="text-white">{{ $shipment->estimated_delivery->format('M d, Y') }}</span></div>@endif
                @if($shipment->user)<div class="flex justify-between"><span class="text-slate-400">User</span><span class="text-white">{{ $shipment->user->name }}</span></div>@endif
            </div>
        </div>

        {{-- Timeline --}}
        <div class="glass-card p-6">
            <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-6">{{ __('Track') }}ing History</h3>
            @forelse($shipment->updates->reverse() as $index => $update)
                <div class="timeline-item">
                    <div class="timeline-dot {{ $index === 0 ? 'timeline-dot-active' : '' }}">
                        @if($index !== 0)<span class="w-2 h-2 rounded-full bg-slate-600"></span>@endif
                    </div>
                    <div>
                        <p class="text-sm font-medium text-white capitalize">{{ str_replace('_', ' ', $update->status) }}</p>
                        <p class="text-xs text-blue-400 mt-0.5">{{ $update->location_name }}</p>
                        @if($update->description)<p class="text-xs text-slate-500 mt-1">{{ $update->description }}</p>@endif
                        <p class="text-xs text-slate-600 mt-1">{{ $update->update_time->format('M d, Y · H:i') }}</p>
                        @if($update->lat && $update->lng)
                            <p class="text-xs text-slate-600">📍 {{ number_format($update->lat, 4) }}, {{ number_format($update->lng, 4) }}</p>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-sm text-slate-500">No tracking updates yet.</p>
            @endforelse
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
(function() {
    const currentLat = {{ $shipment->current_lat ?? $shipment->origin_lat ?? 40.7128 }};
    const currentLng = {{ $shipment->current_lng ?? $shipment->origin_lng ?? -74.0060 }};

    const map = L.map('admin-map', { zoomControl: true, scrollWheelZoom: true });
    L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; OSM &copy; CARTO', subdomains: 'abcd', maxZoom: 19
    }).addTo(map);

    // Draggable marker
    const marker = L.marker([currentLat, currentLng], { draggable: true }).addTo(map);

    marker.on('dragend', function(e) {
        const pos = marker.getLatLng();
        document.getElementById('admin-lat').value = pos.lat.toFixed(7);
        document.getElementById('admin-lng').value = pos.lng.toFixed(7);
        document.getElementById('update-lat').value = pos.lat.toFixed(7);
        document.getElementById('update-lng').value = pos.lng.toFixed(7);
    });

    // Plot waypoints
    const points = [];
    @if($shipment->origin_lat && $shipment->origin_lng)
        points.push([{{ $shipment->origin_lat }}, {{ $shipment->origin_lng }}]);
        L.marker([{{ $shipment->origin_lat }}, {{ $shipment->origin_lng }}], {
            icon: L.divIcon({ className: 'shipment-marker', html: '<div style="width:12px;height:12px;background:#10b981;border-radius:50%;border:2px solid #064e3b;"></div>', iconSize: [12,12], iconAnchor: [6,6] })
        }).addTo(map).bindPopup('<div style="color:#000;">Origin</div>');
    @endif

    @foreach($shipment->updates as $u)
        @if($u->lat && $u->lng)
            points.push([{{ $u->lat }}, {{ $u->lng }}]);
        @endif
    @endforeach

    @if($shipment->destination_lat && $shipment->destination_lng)
        points.push([{{ $shipment->destination_lat }}, {{ $shipment->destination_lng }}]);
        L.marker([{{ $shipment->destination_lat }}, {{ $shipment->destination_lng }}], {
            icon: L.divIcon({ className: 'shipment-marker', html: '<div style="width:12px;height:12px;background:#f59e0b;border-radius:50%;border:2px solid #78350f;"></div>', iconSize: [12,12], iconAnchor: [6,6] })
        }).addTo(map).bindPopup('<div style="color:#000;">Destination</div>');
    @endif

    if (points.length >= 2) {
        L.polyline(points, { color: '#3b82f6', weight: 2, opacity: 0.5, dashArray: '6, 10' }).addTo(map);
        map.fitBounds(points, { padding: [40, 40] });
    } else {
        map.setView([currentLat, currentLng], 8);
    }

    // Click on map to set position
    map.on('click', function(e) {
        marker.setLatLng(e.latlng);
        document.getElementById('admin-lat').value = e.latlng.lat.toFixed(7);
        document.getElementById('admin-lng').value = e.latlng.lng.toFixed(7);
        document.getElementById('update-lat').value = e.latlng.lat.toFixed(7);
        document.getElementById('update-lng').value = e.latlng.lng.toFixed(7);
    });
})();
</script>
@endpush
