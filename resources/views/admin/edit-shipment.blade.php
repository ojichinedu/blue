@extends('layouts.admin')

@section('title', 'Edit Shipment Details')
@section('page_title', 'Edit Shipment ' . $shipment->tracking_number)

@section('content')
@php
    $originPreset = '';
    $destPreset = '';
    $currentPreset = '';
    $presets = [
        'US' => [40.712800, -74.006000],
        'UK' => [51.507400, -0.127800],
        'CN' => [39.904200, 116.407400],
        'DE' => [52.520000, 13.405000],
        'FR' => [48.856600, 2.352200],
        'CA' => [45.421500, -75.697200],
        'AU' => [-35.280900, 149.130000],
        'JP' => [35.676200, 139.650300],
        'IN' => [28.613900, 77.209000],
        'NG' => [9.082000, 8.675300],
        'AE' => [24.453900, 54.377300],
        'SA' => [24.713600, 46.675300],
        'ZA' => [-33.924900, 18.424100],
        'BR' => [-15.793800, -47.882800],
        'SG' => [1.352100, 103.819800],
        'TR' => [39.933400, 32.859700],
        'IT' => [41.902800, 12.496400],
        'ES' => [40.416800, -3.703800],
        'NL' => [52.367600, 4.904100],
        'BE' => [50.850300, 4.351700],
        'CH' => [46.948000, 7.447400]
    ];
    
    foreach ($presets as $code => $coords) {
        if (abs((float)$shipment->origin_lat - $coords[0]) < 0.0001 && abs((float)$shipment->origin_lng - $coords[1]) < 0.0001) {
            $originPreset = $code;
            break;
        }
    }
    
    foreach ($presets as $code => $coords) {
        if (abs((float)$shipment->destination_lat - $coords[0]) < 0.0001 && abs((float)$shipment->destination_lng - $coords[1]) < 0.0001) {
            $destPreset = $code;
            break;
        }
    }

    foreach ($presets as $code => $coords) {
        if (abs((float)$shipment->current_lat - $coords[0]) < 0.0001 && abs((float)$shipment->current_lng - $coords[1]) < 0.0001) {
            $currentPreset = $code;
            break;
        }
    }
@endphp
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('admin.shipment.show', $shipment->id) }}" class="btn-secondary btn-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Shipment Details
        </a>
    </div>

    <div class="glass-card p-8">
        <form action="{{ route('admin.shipment.updateDetails', $shipment->id) }}" method="POST" id="edit-shipment-form">
            @csrf
            @method('PUT')

            {{-- 1. Client / User Association --}}
            <div class="border-b border-white/5 pb-6 mb-6">
                <h3 class="text-lg font-bold text-white mb-4">Client Association</h3>
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label for="user_id" class="form-label">Associate Customer User</label>
                        <select name="user_id" id="user_id" class="form-select">
                            <option value="">Guest (No Associated User Account)</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id', $shipment->user_id) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-slate-500 mt-1">Select a customer account to let them track this shipment in their dashboard.</p>
                    </div>
                </div>
            </div>

            {{-- 2. Sender and Receiver Details --}}
            <div class="border-b border-white/5 pb-6 mb-6">
                <div class="grid md:grid-cols-2 gap-8">
                    {{-- Sender --}}
                    <div>
                        <h3 class="text-lg font-bold text-white mb-4">Sender Details</h3>
                        <div class="space-y-4">
                            <div>
                                <label for="sender_name" class="form-label">Sender Name</label>
                                <input type="text" name="sender_name" id="sender_name" class="form-input" value="{{ old('sender_name', $shipment->sender_name) }}" required>
                            </div>
                            <div>
                                <label for="sender_email" class="form-label">Sender Email</label>
                                <input type="email" name="sender_email" id="sender_email" class="form-input" value="{{ old('sender_email', $shipment->sender_email) }}" required>
                            </div>
                            <div>
                                <label for="sender_phone" class="form-label">Sender Phone</label>
                                <input type="text" name="sender_phone" id="sender_phone" class="form-input" value="{{ old('sender_phone', $shipment->sender_phone) }}" required>
                            </div>
                            <div>
                                <label for="sender_address" class="form-label">Sender Address</label>
                                <textarea name="sender_address" id="sender_address" rows="3" class="form-input" required>{{ old('sender_address', $shipment->sender_address) }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Receiver --}}
                    <div>
                        <h3 class="text-lg font-bold text-white mb-4">Receiver Details</h3>
                        <div class="space-y-4">
                            <div>
                                <label for="receiver_name" class="form-label">Receiver Name</label>
                                <input type="text" name="receiver_name" id="receiver_name" class="form-input" value="{{ old('receiver_name', $shipment->receiver_name) }}" required>
                            </div>
                            <div>
                                <label for="receiver_email" class="form-label">Receiver Email</label>
                                <input type="email" name="receiver_email" id="receiver_email" class="form-input" value="{{ old('receiver_email', $shipment->receiver_email) }}" required>
                            </div>
                            <div>
                                <label for="receiver_phone" class="form-label">Receiver Phone</label>
                                <input type="text" name="receiver_phone" id="receiver_phone" class="form-input" value="{{ old('receiver_phone', $shipment->receiver_phone) }}" required>
                            </div>
                            <div>
                                <label for="receiver_address" class="form-label">Receiver Address</label>
                                <textarea name="receiver_address" id="receiver_address" rows="3" class="form-input" required>{{ old('receiver_address', $shipment->receiver_address) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 3. Package & Status Details --}}
            <div class="border-b border-white/5 pb-6 mb-6">
                <h3 class="text-lg font-bold text-white mb-4">Package & Shipping Details</h3>
                <div class="grid md:grid-cols-3 gap-6">
                    <div>
                        <label for="package_type" class="form-label">Package Type</label>
                        <select name="package_type" id="package_type" class="form-select" required>
                            <option value="parcel" {{ old('package_type', $shipment->package_type) == 'parcel' ? 'selected' : '' }}>Parcel</option>
                            <option value="document" {{ old('package_type', $shipment->package_type) == 'document' ? 'selected' : '' }}>Document</option>
                            <option value="freight" {{ old('package_type', $shipment->package_type) == 'freight' ? 'selected' : '' }}>Freight</option>
                        </select>
                    </div>
                    <div>
                        <label for="weight" class="form-label">Weight (kg)</label>
                        <input type="number" step="0.01" name="weight" id="weight" class="form-input" value="{{ old('weight', $shipment->weight) }}">
                    </div>
                    <div>
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="pending" {{ old('status', $shipment->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="picked_up" {{ old('status', $shipment->status) == 'picked_up' ? 'selected' : '' }}>Picked Up</option>
                            <option value="in_transit" {{ old('status', $shipment->status) == 'in_transit' ? 'selected' : '' }}>In Transit</option>
                            <option value="out_for_delivery" {{ old('status', $shipment->status) == 'out_for_delivery' ? 'selected' : '' }}>Out for Delivery</option>
                            <option value="delivered" {{ old('status', $shipment->status) == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ old('status', $shipment->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                </div>
                <div class="mt-4">
                    <label for="package_description" class="form-label">Package Description</label>
                    <input type="text" name="package_description" id="package_description" class="form-input" value="{{ old('package_description', $shipment->package_description) }}">
                </div>
            </div>

            {{-- 4. Map Coordinates & Delivery --}}
            <div>
                <h3 class="text-lg font-bold text-white mb-4">Route Coordinates & Schedule</h3>
                <div class="grid md:grid-cols-2 gap-6 mb-4">
                    <div>
                        <label for="estimated_delivery" class="form-label">Estimated Delivery Date</label>
                        <input type="date" name="estimated_delivery" id="estimated_delivery" class="form-input" value="{{ old('estimated_delivery', $shipment->estimated_delivery ? $shipment->estimated_delivery->format('Y-m-d') : '') }}" required>
                    </div>
                </div>
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="space-y-4">
                        <h4 class="text-sm font-semibold text-blue-400">Origin Location</h4>
                        <div>
                            <label class="form-label !text-xs">Country Preset</label>
                            <select id="origin_country_preset" class="form-select !py-2" onchange="updateCoordinates('origin', this.value)">
                                <option value="">-- Custom Location --</option>
                                <option value="US" {{ $originPreset === 'US' ? 'selected' : '' }}>United States (New York)</option>
                                <option value="UK" {{ $originPreset === 'UK' ? 'selected' : '' }}>United Kingdom (London)</option>
                                <option value="DE" {{ $originPreset === 'DE' ? 'selected' : '' }}>Germany (Berlin)</option>
                                <option value="FR" {{ $originPreset === 'FR' ? 'selected' : '' }}>France (Paris)</option>
                                <option value="CN" {{ $originPreset === 'CN' ? 'selected' : '' }}>China (Beijing)</option>
                                <option value="CA" {{ $originPreset === 'CA' ? 'selected' : '' }}>Canada (Ottawa)</option>
                                <option value="AU" {{ $originPreset === 'AU' ? 'selected' : '' }}>Australia (Canberra)</option>
                                <option value="JP" {{ $originPreset === 'JP' ? 'selected' : '' }}>Japan (Tokyo)</option>
                                <option value="IN" {{ $originPreset === 'IN' ? 'selected' : '' }}>India (New Delhi)</option>
                                <option value="NG" {{ $originPreset === 'NG' ? 'selected' : '' }}>Nigeria (Abuja)</option>
                                <option value="AE" {{ $originPreset === 'AE' ? 'selected' : '' }}>United Arab Emirates (Abu Dhabi)</option>
                                <option value="SA" {{ $originPreset === 'SA' ? 'selected' : '' }}>Saudi Arabia (Riyadh)</option>
                                <option value="ZA" {{ $originPreset === 'ZA' ? 'selected' : '' }}>South Africa (Cape Town)</option>
                                <option value="BR" {{ $originPreset === 'BR' ? 'selected' : '' }}>Brazil (Brasilia)</option>
                                <option value="SG" {{ $originPreset === 'SG' ? 'selected' : '' }}>Singapore</option>
                                <option value="TR" {{ $originPreset === 'TR' ? 'selected' : '' }}>Turkey (Ankara)</option>
                                <option value="IT" {{ $originPreset === 'IT' ? 'selected' : '' }}>Italy (Rome)</option>
                                <option value="ES" {{ $originPreset === 'ES' ? 'selected' : '' }}>Spain (Madrid)</option>
                                <option value="NL" {{ $originPreset === 'NL' ? 'selected' : '' }}>Netherlands (Amsterdam)</option>
                                <option value="BE" {{ $originPreset === 'BE' ? 'selected' : '' }}>Belgium (Brussels)</option>
                                <option value="CH" {{ $originPreset === 'CH' ? 'selected' : '' }}>Switzerland (Bern)</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label !text-xs">Latitude</label>
                            <input type="number" step="0.000001" name="origin_lat" id="origin_lat" class="form-input !py-2" value="{{ old('origin_lat', $shipment->origin_lat) }}" required>
                        </div>
                        <div>
                            <label class="form-label !text-xs">Longitude</label>
                            <input type="number" step="0.000001" name="origin_lng" id="origin_lng" class="form-input !py-2" value="{{ old('origin_lng', $shipment->origin_lng) }}" required>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h4 class="text-sm font-semibold text-cyan-400">Destination Location</h4>
                        <div>
                            <label class="form-label !text-xs">Country Preset</label>
                            <select id="destination_country_preset" class="form-select !py-2" onchange="updateCoordinates('destination', this.value)">
                                <option value="">-- Custom Location --</option>
                                <option value="US" {{ $destPreset === 'US' ? 'selected' : '' }}>United States (New York)</option>
                                <option value="UK" {{ $destPreset === 'UK' ? 'selected' : '' }}>United Kingdom (London)</option>
                                <option value="DE" {{ $destPreset === 'DE' ? 'selected' : '' }}>Germany (Berlin)</option>
                                <option value="FR" {{ $destPreset === 'FR' ? 'selected' : '' }}>France (Paris)</option>
                                <option value="CN" {{ $destPreset === 'CN' ? 'selected' : '' }}>China (Beijing)</option>
                                <option value="CA" {{ $destPreset === 'CA' ? 'selected' : '' }}>Canada (Ottawa)</option>
                                <option value="AU" {{ $destPreset === 'AU' ? 'selected' : '' }}>Australia (Canberra)</option>
                                <option value="JP" {{ $destPreset === 'JP' ? 'selected' : '' }}>Japan (Tokyo)</option>
                                <option value="IN" {{ $destPreset === 'IN' ? 'selected' : '' }}>India (New Delhi)</option>
                                <option value="NG" {{ $destPreset === 'NG' ? 'selected' : '' }}>Nigeria (Abuja)</option>
                                <option value="AE" {{ $destPreset === 'AE' ? 'selected' : '' }}>United Arab Emirates (Abu Dhabi)</option>
                                <option value="SA" {{ $destPreset === 'SA' ? 'selected' : '' }}>Saudi Arabia (Riyadh)</option>
                                <option value="ZA" {{ $destPreset === 'ZA' ? 'selected' : '' }}>South Africa (Cape Town)</option>
                                <option value="BR" {{ $destPreset === 'BR' ? 'selected' : '' }}>Brazil (Brasilia)</option>
                                <option value="SG" {{ $destPreset === 'SG' ? 'selected' : '' }}>Singapore</option>
                                <option value="TR" {{ $destPreset === 'TR' ? 'selected' : '' }}>Turkey (Ankara)</option>
                                <option value="IT" {{ $destPreset === 'IT' ? 'selected' : '' }}>Italy (Rome)</option>
                                <option value="ES" {{ $destPreset === 'ES' ? 'selected' : '' }}>Spain (Madrid)</option>
                                <option value="NL" {{ $destPreset === 'NL' ? 'selected' : '' }}>Netherlands (Amsterdam)</option>
                                <option value="BE" {{ $destPreset === 'BE' ? 'selected' : '' }}>Belgium (Brussels)</option>
                                <option value="CH" {{ $destPreset === 'CH' ? 'selected' : '' }}>Switzerland (Bern)</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label !text-xs">Latitude</label>
                            <input type="number" step="0.000001" name="destination_lat" id="destination_lat" class="form-input !py-2" value="{{ old('destination_lat', $shipment->destination_lat) }}" required>
                        </div>
                        <div>
                            <label class="form-label !text-xs">Longitude</label>
                            <input type="number" step="0.000001" name="destination_lng" id="destination_lng" class="form-input !py-2" value="{{ old('destination_lng', $shipment->destination_lng) }}" required>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h4 class="text-sm font-semibold text-emerald-400">Current Position Location</h4>
                        <div>
                            <label class="form-label !text-xs">Country Preset</label>
                            <select id="current_country_preset" class="form-select !py-2" onchange="updateCoordinates('current', this.value)">
                                <option value="">-- Custom Location --</option>
                                <option value="US" {{ $currentPreset === 'US' ? 'selected' : '' }}>United States (New York)</option>
                                <option value="UK" {{ $currentPreset === 'UK' ? 'selected' : '' }}>United Kingdom (London)</option>
                                <option value="DE" {{ $currentPreset === 'DE' ? 'selected' : '' }}>Germany (Berlin)</option>
                                <option value="FR" {{ $currentPreset === 'FR' ? 'selected' : '' }}>France (Paris)</option>
                                <option value="CN" {{ $currentPreset === 'CN' ? 'selected' : '' }}>China (Beijing)</option>
                                <option value="CA" {{ $currentPreset === 'CA' ? 'selected' : '' }}>Canada (Ottawa)</option>
                                <option value="AU" {{ $currentPreset === 'AU' ? 'selected' : '' }}>Australia (Canberra)</option>
                                <option value="JP" {{ $currentPreset === 'JP' ? 'selected' : '' }}>Japan (Tokyo)</option>
                                <option value="IN" {{ $currentPreset === 'IN' ? 'selected' : '' }}>India (New Delhi)</option>
                                <option value="NG" {{ $currentPreset === 'NG' ? 'selected' : '' }}>Nigeria (Abuja)</option>
                                <option value="AE" {{ $currentPreset === 'AE' ? 'selected' : '' }}>United Arab Emirates (Abu Dhabi)</option>
                                <option value="SA" {{ $currentPreset === 'SA' ? 'selected' : '' }}>Saudi Arabia (Riyadh)</option>
                                <option value="ZA" {{ $currentPreset === 'ZA' ? 'selected' : '' }}>South Africa (Cape Town)</option>
                                <option value="BR" {{ $currentPreset === 'BR' ? 'selected' : '' }}>Brazil (Brasilia)</option>
                                <option value="SG" {{ $currentPreset === 'SG' ? 'selected' : '' }}>Singapore</option>
                                <option value="TR" {{ $currentPreset === 'TR' ? 'selected' : '' }}>Turkey (Ankara)</option>
                                <option value="IT" {{ $currentPreset === 'IT' ? 'selected' : '' }}>Italy (Rome)</option>
                                <option value="ES" {{ $currentPreset === 'ES' ? 'selected' : '' }}>Spain (Madrid)</option>
                                <option value="NL" {{ $currentPreset === 'NL' ? 'selected' : '' }}>Netherlands (Amsterdam)</option>
                                <option value="BE" {{ $currentPreset === 'BE' ? 'selected' : '' }}>Belgium (Brussels)</option>
                                <option value="CH" {{ $currentPreset === 'CH' ? 'selected' : '' }}>Switzerland (Bern)</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label !text-xs">Latitude</label>
                            <input type="number" step="0.000001" name="current_lat" id="current_lat" class="form-input !py-2" value="{{ old('current_lat', $shipment->current_lat) }}" required>
                        </div>
                        <div>
                            <label class="form-label !text-xs">Longitude</label>
                            <input type="number" step="0.000001" name="current_lng" id="current_lng" class="form-input !py-2" value="{{ old('current_lng', $shipment->current_lng) }}" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-end">
                <button type="submit" class="btn-primary flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const countryCoords = {
        'US': { lat: 40.712800, lng: -74.006000 },
        'UK': { lat: 51.507400, lng: -0.127800 },
        'CN': { lat: 39.904200, lng: 116.407400 },
        'DE': { lat: 52.520000, lng: 13.405000 },
        'FR': { lat: 48.856600, lng: 2.352200 },
        'CA': { lat: 45.421500, lng: -75.697200 },
        'AU': { lat: -35.280900, lng: 149.130000 },
        'JP': { lat: 35.676200, lng: 139.650300 },
        'IN': { lat: 28.613900, lng: 77.209000 },
        'NG': { lat: 9.082000, lng: 8.675300 },
        'AE': { lat: 24.453900, lng: 54.377300 },
        'SA': { lat: 24.713600, lng: 46.675300 },
        'ZA': { lat: -33.924900, lng: 18.424100 },
        'BR': { lat: -15.793800, lng: -47.882800 },
        'SG': { lat: 1.352100, lng: 103.819800 },
        'TR': { lat: 39.933400, lng: 32.859700 },
        'IT': { lat: 41.902800, lng: 12.496400 },
        'ES': { lat: 40.416800, lng: -3.703800 },
        'NL': { lat: 52.367600, lng: 4.904100 },
        'BE': { lat: 50.850300, lng: 4.351700 },
        'CH': { lat: 46.948000, lng: 7.447400 }
    };

    function updateCoordinates(type, countryCode) {
        if (!countryCode || !countryCoords[countryCode]) return;
        
        const latInput = document.getElementById(type + '_lat');
        const lngInput = document.getElementById(type + '_lng');
        
        if (latInput && lngInput) {
            latInput.value = countryCoords[countryCode].lat.toFixed(6);
            lngInput.value = countryCoords[countryCode].lng.toFixed(6);
        }
        
        // Auto-sync current position if updating origin on edit page (if status is pending)
        if (type === 'origin') {
            const statusSelect = document.getElementById('status');
            if (statusSelect && statusSelect.value === 'pending') {
                const currentLat = document.getElementById('current_lat');
                const currentLng = document.getElementById('current_lng');
                const currentSelect = document.getElementById('current_country_preset');
                
                if (currentLat && currentLng) {
                    currentLat.value = countryCoords[countryCode].lat.toFixed(6);
                    currentLng.value = countryCoords[countryCode].lng.toFixed(6);
                }
                if (currentSelect) {
                    currentSelect.value = countryCode;
                }
            }
        }
    }
</script>
@endpush

