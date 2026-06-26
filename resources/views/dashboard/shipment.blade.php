@extends('layouts.public')

@section('title', 'Shipment ' . $shipment->tracking_number)

@section('content')

<section class="relative pt-28 pb-24 overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-blue-900/10 via-slate-950 to-slate-950"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Back --}}
        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-slate-400 hover:text-white mb-6 transition-colors text-sm">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Dashboard
        </a>

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <h1 class="text-2xl font-bold text-white" style="font-family: 'Outfit', sans-serif;">{{ $shipment->tracking_number }}</h1>
                    <span class="badge badge-{{ $shipment->status }}">
                        <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                        {{ $shipment->status_label }}
                    </span>
                </div>
                <p class="text-slate-400 text-sm">{{ $shipment->sender_name }} → {{ $shipment->receiver_name }}</p>
            </div>
            <a href="{{ route('track.result', $shipment->tracking_number) }}" class="btn-primary btn-sm mt-4 md:mt-0" id="shipment-track-btn">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                Open Live {{ __('Track') }}er
            </a>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            {{-- Map --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="glass-card overflow-hidden">
                    <div class="px-6 py-4 border-b border-white/5 flex items-center gap-3">
                        <div class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></div>
                        <h2 class="text-sm font-semibold text-white">Live Map</h2>
                    </div>
                    <div id="detail-map" style="height: 400px; z-index: 1;"></div>
                </div>

                {{-- Details --}}
                <div class="grid sm:grid-cols-2 gap-6">
                    <div class="glass-card p-6">
                        <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-4">Sender</h3>
                        <p class="text-white font-medium">{{ $shipment->sender_name }}</p>
                        <p class="text-sm text-slate-400 mt-1">{{ $shipment->sender_email }}</p>
                        <p class="text-sm text-slate-400">{{ $shipment->sender_phone }}</p>
                        <p class="text-sm text-slate-400 mt-2">{{ $shipment->sender_address }}</p>
                    </div>
                    <div class="glass-card p-6">
                        <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-4">Receiver</h3>
                        <p class="text-white font-medium">{{ $shipment->receiver_name }}</p>
                        <p class="text-sm text-slate-400 mt-1">{{ $shipment->receiver_email }}</p>
                        <p class="text-sm text-slate-400">{{ $shipment->receiver_phone }}</p>
                        <p class="text-sm text-slate-400 mt-2">{{ $shipment->receiver_address }}</p>
                    </div>
                </div>
            </div>

            {{-- Timeline --}}
            <div>
                <div class="glass-card p-6 mb-6">
                    <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-4">Package Info</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between"><span class="text-sm text-slate-400">Type</span><span class="text-sm text-white capitalize">{{ $shipment->package_type }}</span></div>
                        @if($shipment->weight)<div class="flex justify-between"><span class="text-sm text-slate-400">Weight</span><span class="text-sm text-white">{{ $shipment->weight }} kg</span></div>@endif
                        @if($shipment->estimated_delivery)<div class="flex justify-between"><span class="text-sm text-slate-400">Est. Delivery</span><span class="text-sm text-white">{{ $shipment->estimated_delivery->format('M d, Y') }}</span></div>@endif
                    </div>
                </div>

                <div class="glass-card p-6">
                    <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-6">{{ __('Track') }}ing History</h3>
                    @foreach($shipment->updates->reverse() as $index => $update)
                        <div class="timeline-item">
                            <div class="timeline-dot {{ $index === 0 ? 'timeline-dot-active' : '' }}">
                                @if($index !== 0)<span class="w-2 h-2 rounded-full bg-slate-600"></span>@endif
                            </div>
                            <div>
                                <p class="text-sm font-medium text-white capitalize">{{ str_replace('_', ' ', $update->status) }}</p>
                                <p class="text-xs text-blue-400 mt-0.5">{{ $update->location_name }}</p>
                                @if($update->description)<p class="text-xs text-slate-500 mt-1">{{ $update->description }}</p>@endif
                                <p class="text-xs text-slate-600 mt-1">{{ $update->update_time->format('M d, Y · H:i') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
(function() {
    const data = {!! json_encode([
        'origin' => ['lat' => (float)$shipment->origin_lat, 'lng' => (float)$shipment->origin_lng],
        'destination' => ['lat' => (float)$shipment->destination_lat, 'lng' => (float)$shipment->destination_lng],
        'current' => ['lat' => (float)$shipment->current_lat, 'lng' => (float)$shipment->current_lng],
        'waypoints' => $shipment->updates->map(fn($u) => ['lat' => (float)$u->lat, 'lng' => (float)$u->lng, 'location' => $u->location_name])->toArray(),
    ]) !!};

    const map = L.map('detail-map', { zoomControl: true, scrollWheelZoom: true });
    L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; OSM &copy; CARTO', subdomains: 'abcd', maxZoom: 19
    }).addTo(map);

    const points = [];
    if (data.origin.lat) {
        points.push([data.origin.lat, data.origin.lng]);
        L.marker([data.origin.lat, data.origin.lng], { icon: L.divIcon({ className: 'shipment-marker', html: '<div style="width:14px;height:14px;background:#10b981;border-radius:50%;border:3px solid #064e3b;box-shadow:0 0 10px rgba(16,185,129,0.4);"></div>', iconSize: [14,14], iconAnchor: [7,7] }) }).addTo(map).bindPopup('<div style="color:#000;"><strong>Origin</strong></div>');
    }
    data.waypoints.forEach(wp => { if (wp.lat) points.push([wp.lat, wp.lng]); });
    if (data.destination.lat) {
        points.push([data.destination.lat, data.destination.lng]);
        L.marker([data.destination.lat, data.destination.lng], { icon: L.divIcon({ className: 'shipment-marker', html: '<div style="width:14px;height:14px;background:#f59e0b;border-radius:50%;border:3px solid #78350f;box-shadow:0 0 10px rgba(245,158,11,0.4);"></div>', iconSize: [14,14], iconAnchor: [7,7] }) }).addTo(map).bindPopup('<div style="color:#000;"><strong>Destination</strong></div>');
    }

    if (points.length >= 2) {
        L.polyline(points, { color: '#3b82f6', weight: 3, opacity: 0.7 }).addTo(map);
        map.fitBounds(points, { padding: [40, 40] });
    } else if (data.current.lat) {
        map.setView([data.current.lat, data.current.lng], 10);
    } else {
        map.setView([20, 0], 2);
    }

    if (data.current.lat) {
        L.marker([data.current.lat, data.current.lng], { icon: L.divIcon({ className: 'shipment-marker', html: '<div class="moving-marker"></div>', iconSize: [32,32], iconAnchor: [16,16] }), zIndexOffset: 1000 }).addTo(map);
    }
})();
</script>
@endpush
