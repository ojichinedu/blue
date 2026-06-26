@extends('layouts.public')

@section('title', '{{ __('Track') }}ing ' . $shipment->tracking_number)
@section('meta_description', 'Live tracking for shipment ' . $shipment->tracking_number)

@section('content')

<section class="relative pt-28 pb-24 overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-blue-900/10 via-slate-950 to-slate-950"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Success Banner --}}
        @if(session('success'))
            <div class="mb-8 bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 px-6 py-4 rounded-xl animate-fade-in-up flex items-center gap-3">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
            <div class="animate-fade-in-up">
                <div class="flex items-center gap-3 mb-2">
                    <h1 class="text-2xl font-bold text-white" style="font-family: 'Outfit', sans-serif;">
                        {{ $shipment->tracking_number }}
                    </h1>
                    <span class="badge badge-{{ $shipment->status }}">
                        <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                        {{ $shipment->status_label }}
                    </span>
                </div>
                <p class="text-slate-400 text-sm">
                    {{ $shipment->sender_name }} → {{ $shipment->receiver_name }}
                </p>
            </div>
            <a href="{{ route('track') }}" class="btn-secondary btn-sm animate-fade-in-up delay-100" id="back-to-track">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                {{ __('Track') }} Another
            </a>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            {{-- Map Column --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Live Map --}}
                <div class="glass-card overflow-hidden animate-fade-in-up delay-200" id="map-container">
                    <div class="px-6 py-4 border-b border-white/5 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></div>
                            <h2 class="text-sm font-semibold text-white">Live {{ __('Track') }}ing Map</h2>
                        </div>
                        <span class="text-xs text-slate-500" id="last-updated">Updating...</span>
                    </div>
                    <div id="tracking-map" style="height: 450px; z-index: 1;"></div>
                </div>

                {{-- Shipment Details --}}
                <div class="grid sm:grid-cols-2 gap-6 animate-fade-in-up delay-300">
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

            {{-- Timeline Column --}}
            <div class="animate-fade-in-up delay-300">
                {{-- Package Info Card --}}
                <div class="glass-card p-6 mb-6">
                    <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-4">Package Info</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-slate-400">Type</span>
                            <span class="text-sm text-white capitalize">{{ $shipment->package_type }}</span>
                        </div>
                        @if($shipment->weight)
                        <div class="flex justify-between">
                            <span class="text-sm text-slate-400">Weight</span>
                            <span class="text-sm text-white">{{ $shipment->weight }} kg</span>
                        </div>
                        @endif
                        @if($shipment->estimated_delivery)
                        <div class="flex justify-between">
                            <span class="text-sm text-slate-400">Est. Delivery</span>
                            <span class="text-sm text-white">{{ $shipment->estimated_delivery->format('M d, Y') }}</span>
                        </div>
                        @endif
                        @if($shipment->actual_delivery)
                        <div class="flex justify-between">
                            <span class="text-sm text-slate-400">Delivered</span>
                            <span class="text-sm text-emerald-400">{{ $shipment->actual_delivery->format('M d, Y H:i') }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Timeline --}}
                <div class="glass-card p-6">
                    <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-6">{{ __('Track') }}ing History</h3>
                    <div class="space-y-0">
                        @foreach($shipment->updates->reverse() as $index => $update)
                            <div class="timeline-item">
                                <div class="timeline-dot {{ $index === 0 ? 'timeline-dot-active' : '' }}">
                                    @if($index !== 0)
                                        <span class="w-2 h-2 rounded-full bg-slate-600"></span>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-white capitalize">{{ str_replace('_', ' ', $update->status) }}</p>
                                    <p class="text-xs text-blue-400 mt-0.5">{{ $update->location_name }}</p>
                                    @if($update->description)
                                        <p class="text-xs text-slate-500 mt-1">{{ $update->description }}</p>
                                    @endif
                                    <p class="text-xs text-slate-600 mt-1">{{ $update->update_time->format('M d, Y · H:i') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
(function() {
    const trackingNumber = {!! json_encode($shipment->tracking_number) !!};
    const shipmentData = {!! json_encode([
        'status' => $shipment->status,
        'origin' => ['lat' => (float)$shipment->origin_lat, 'lng' => (float)$shipment->origin_lng],
        'destination' => ['lat' => (float)$shipment->destination_lat, 'lng' => (float)$shipment->destination_lng],
        'current' => ['lat' => (float)$shipment->current_lat, 'lng' => (float)$shipment->current_lng],
        'waypoints' => $shipment->updates->map(fn($u) => [
            'lat' => (float)$u->lat,
            'lng' => (float)$u->lng,
            'status' => $u->status,
            'location' => $u->location_name,
            'time' => $u->update_time->toIso8601String(),
        ])->toArray(),
    ]) !!};

    // Initialize map
    const map = L.map('tracking-map', {
        zoomControl: true,
        scrollWheelZoom: true,
    });

    // Dark tile layer for premium look
    L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OSM</a> &copy; <a href="https://carto.com/">CARTO</a>',
        subdomains: 'abcd',
        maxZoom: 19
    }).addTo(map);

    // Custom icons
    const originIcon = L.divIcon({
        className: 'shipment-marker',
        html: '<div style="width:16px;height:16px;background:#10b981;border-radius:50%;border:3px solid #064e3b;box-shadow:0 0 12px rgba(16,185,129,0.5);"></div>',
        iconSize: [16, 16],
        iconAnchor: [8, 8],
    });

    const destinationIcon = L.divIcon({
        className: 'shipment-marker',
        html: '<div style="width:16px;height:16px;background:#f59e0b;border-radius:50%;border:3px solid #78350f;box-shadow:0 0 12px rgba(245,158,11,0.5);"></div>',
        iconSize: [16, 16],
        iconAnchor: [8, 8],
    });

    const movingIcon = L.divIcon({
        className: 'shipment-marker',
        html: '<div class="moving-marker"></div>',
        iconSize: [32, 32],
        iconAnchor: [16, 16],
    });

    const waypointIcon = L.divIcon({
        className: 'shipment-marker',
        html: '<div style="width:10px;height:10px;background:#6366f1;border-radius:50%;border:2px solid #312e81;box-shadow:0 0 8px rgba(99,102,241,0.4);"></div>',
        iconSize: [10, 10],
        iconAnchor: [5, 5],
    });

    // Add origin marker
    if (shipmentData.origin.lat && shipmentData.origin.lng) {
        L.marker([shipmentData.origin.lat, shipmentData.origin.lng], { icon: originIcon })
            .addTo(map)
            .bindPopup('<div style="color:#000;"><strong>📍 Origin</strong><br>Pickup location</div>');
    }

    // Add destination marker
    if (shipmentData.destination.lat && shipmentData.destination.lng) {
        L.marker([shipmentData.destination.lat, shipmentData.destination.lng], { icon: destinationIcon })
            .addTo(map)
            .bindPopup('<div style="color:#000;"><strong>🏁 Destination</strong><br>Delivery location</div>');
    }

    // Build route from waypoints
    const routePoints = [];
    if (shipmentData.origin.lat && shipmentData.origin.lng) {
        routePoints.push([shipmentData.origin.lat, shipmentData.origin.lng]);
    }

    shipmentData.waypoints.forEach((wp, idx) => {
        if (wp.lat && wp.lng) {
            routePoints.push([wp.lat, wp.lng]);
            if (idx > 0) { // skip origin waypoint marker
                L.marker([wp.lat, wp.lng], { icon: waypointIcon })
                    .addTo(map)
                    .bindPopup(`<div style="color:#000;"><strong>${wp.location}</strong><br><small>${wp.status} · ${new Date(wp.time).toLocaleString()}</small></div>`);
            }
        }
    });

    if (shipmentData.destination.lat && shipmentData.destination.lng) {
        routePoints.push([shipmentData.destination.lat, shipmentData.destination.lng]);
    }

    // Draw route polyline
    if (routePoints.length >= 2) {
        // Dotted future path
        L.polyline(routePoints, {
            color: '#334155',
            weight: 3,
            dashArray: '8, 12',
            opacity: 0.5,
        }).addTo(map);
    }

    // Draw traveled path (origin to current)
    const traveledPoints = [];
    if (shipmentData.origin.lat && shipmentData.origin.lng) {
        traveledPoints.push([shipmentData.origin.lat, shipmentData.origin.lng]);
    }
    shipmentData.waypoints.forEach(wp => {
        if (wp.lat && wp.lng) {
            traveledPoints.push([wp.lat, wp.lng]);
        }
    });

    if (traveledPoints.length >= 2) {
        // Glowing traveled path
        L.polyline(traveledPoints, {
            color: '#3b82f6',
            weight: 4,
            opacity: 0.8,
        }).addTo(map);

        // Glow effect layer
        L.polyline(traveledPoints, {
            color: '#60a5fa',
            weight: 8,
            opacity: 0.2,
        }).addTo(map);
    }

    // Moving marker at current position
    let currentLat = shipmentData.current.lat || shipmentData.origin.lat;
    let currentLng = shipmentData.current.lng || shipmentData.origin.lng;
    const movingMarker = L.marker([currentLat, currentLng], { icon: movingIcon, zIndexOffset: 1000 })
        .addTo(map)
        .bindPopup('<div style="color:#000;"><strong>📦 Current Location</strong><br>Package is here</div>');

    // Fit map bounds
    if (routePoints.length >= 2) {
        map.fitBounds(routePoints, { padding: [50, 50] });
    } else if (currentLat && currentLng) {
        map.setView([currentLat, currentLng], 10);
    } else {
        map.setView([20, 0], 2);
    }

    // ── Live Animation System ──
    let animationTarget = null;
    let animationFrame = null;

    function animateMarker(fromLat, fromLng, toLat, toLng, duration) {
        const startTime = performance.now();
        const startLat = fromLat;
        const startLng = fromLng;
        const deltaLat = toLat - fromLat;
        const deltaLng = toLng - fromLng;

        // Add trail dots
        const trailCount = 8;

        function step(timestamp) {
            const elapsed = timestamp - startTime;
            const progress = Math.min(elapsed / duration, 1);

            // Ease-in-out
            const eased = progress < 0.5
                ? 2 * progress * progress
                : 1 - Math.pow(-2 * progress + 2, 2) / 2;

            const lat = startLat + deltaLat * eased;
            const lng = startLng + deltaLng * eased;

            movingMarker.setLatLng([lat, lng]);

            if (progress < 1) {
                animationFrame = requestAnimationFrame(step);
            } else {
                currentLat = toLat;
                currentLng = toLng;
            }
        }

        if (animationFrame) cancelAnimationFrame(animationFrame);
        animationFrame = requestAnimationFrame(step);
    }

    // Poll for position updates
    function pollPosition() {
        fetch(`/api/shipment/${trackingNumber}/position`)
            .then(r => r.json())
            .then(data => {
                const newLat = data.current_lat;
                const newLng = data.current_lng;

                if (newLat && newLng && (Math.abs(newLat - currentLat) > 0.0001 || Math.abs(newLng - currentLng) > 0.0001)) {
                    // Animate to new position
                    animateMarker(currentLat, currentLng, newLat, newLng, 3000);
                }

                // Update timestamp
                document.getElementById('last-updated').textContent = 'Updated ' + new Date().toLocaleTimeString();
            })
            .catch(() => {
                document.getElementById('last-updated').textContent = 'Connection issue...';
            });
    }

    // Initial animation: smoothly move from origin toward current position
    if (shipmentData.origin.lat && shipmentData.origin.lng &&
        shipmentData.current.lat && shipmentData.current.lng &&
        (Math.abs(shipmentData.current.lat - shipmentData.origin.lat) > 0.0001 ||
         Math.abs(shipmentData.current.lng - shipmentData.origin.lng) > 0.0001)) {

        // Animate along waypoints
        let animIndex = 0;
        const animPoints = [...traveledPoints];

        function animateSegment() {
            if (animIndex < animPoints.length - 1) {
                const from = animPoints[animIndex];
                const to = animPoints[animIndex + 1];
                const dist = Math.sqrt(Math.pow(to[0] - from[0], 2) + Math.pow(to[1] - from[1], 2));
                const duration = Math.max(800, Math.min(dist * 300, 3000));

                animateMarker(from[0], from[1], to[0], to[1], duration);

                setTimeout(() => {
                    animIndex++;
                    animateSegment();
                }, duration + 100);
            }
        }

        // Start initial animation after a short delay
        setTimeout(animateSegment, 1000);
    }

    // Update timestamp
    document.getElementById('last-updated').textContent = 'Updated ' + new Date().toLocaleTimeString();

    // Poll every 10 seconds
    setInterval(pollPosition, 10000);
})();
</script>
@endpush
