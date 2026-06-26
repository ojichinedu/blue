@extends('layouts.admin')

@section('title', 'Create Shipment')
@section('page_title', 'Create New Shipment')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('admin.shipments') }}" class="btn-secondary btn-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Shipments
        </a>
    </div>

    <div class="glass-card p-8">
        <form action="{{ route('admin.shipment.store') }}" method="POST" id="create-shipment-form">
            @csrf

            {{-- 1. Client / User Association --}}
            <div class="border-b border-white/5 pb-6 mb-6">
                <h3 class="text-lg font-bold text-white mb-4">Client Association</h3>
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label for="user_id" class="form-label">Associate Customer User</label>
                        <select name="user_id" id="user_id" class="form-select">
                            <option value="">Guest (No Associated User Account)</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
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
                                <input type="text" name="sender_name" id="sender_name" class="form-input" value="{{ old('sender_name') }}" required>
                            </div>
                            <div>
                                <label for="sender_email" class="form-label">Sender Email</label>
                                <input type="email" name="sender_email" id="sender_email" class="form-input" value="{{ old('sender_email') }}" required>
                            </div>
                            <div>
                                <label for="sender_phone" class="form-label">Sender Phone</label>
                                <input type="text" name="sender_phone" id="sender_phone" class="form-input" value="{{ old('sender_phone') }}" required>
                            </div>
                            <div>
                                <label for="sender_address" class="form-label">Sender Address</label>
                                <textarea name="sender_address" id="sender_address" rows="3" class="form-input" required>{{ old('sender_address') }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Receiver --}}
                    <div>
                        <h3 class="text-lg font-bold text-white mb-4">Receiver Details</h3>
                        <div class="space-y-4">
                            <div>
                                <label for="receiver_name" class="form-label">Receiver Name</label>
                                <input type="text" name="receiver_name" id="receiver_name" class="form-input" value="{{ old('receiver_name') }}" required>
                            </div>
                            <div>
                                <label for="receiver_email" class="form-label">Receiver Email</label>
                                <input type="email" name="receiver_email" id="receiver_email" class="form-input" value="{{ old('receiver_email') }}" required>
                            </div>
                            <div>
                                <label for="receiver_phone" class="form-label">Receiver Phone</label>
                                <input type="text" name="receiver_phone" id="receiver_phone" class="form-input" value="{{ old('receiver_phone') }}" required>
                            </div>
                            <div>
                                <label for="receiver_address" class="form-label">Receiver Address</label>
                                <textarea name="receiver_address" id="receiver_address" rows="3" class="form-input" required>{{ old('receiver_address') }}</textarea>
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
                            <option value="parcel" {{ old('package_type') == 'parcel' ? 'selected' : '' }}>Parcel</option>
                            <option value="document" {{ old('package_type') == 'document' ? 'selected' : '' }}>Document</option>
                            <option value="freight" {{ old('package_type') == 'freight' ? 'selected' : '' }}>Freight</option>
                        </select>
                    </div>
                    <div>
                        <label for="weight" class="form-label">Weight (kg)</label>
                        <input type="number" step="0.01" name="weight" id="weight" class="form-input" value="{{ old('weight', '1.00') }}">
                    </div>
                    <div>
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="picked_up" {{ old('status') == 'picked_up' ? 'selected' : '' }}>Picked Up</option>
                            <option value="in_transit" {{ old('status') == 'in_transit' ? 'selected' : '' }}>In Transit</option>
                            <option value="out_for_delivery" {{ old('status') == 'out_for_delivery' ? 'selected' : '' }}>Out for Delivery</option>
                            <option value="delivered" {{ old('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                </div>
                <div class="mt-4">
                    <label for="package_description" class="form-label">Package Description</label>
                    <input type="text" name="package_description" id="package_description" class="form-input" placeholder="e.g. Electronics, Documents, Machinery" value="{{ old('package_description') }}">
                </div>
            </div>

            {{-- 4. Map Coordinates & Delivery --}}
            <div>
                <h3 class="text-lg font-bold text-white mb-4">Route Coordinates & Schedule</h3>
                <div class="grid md:grid-cols-2 gap-6 mb-4">
                    <div>
                        <label for="estimated_delivery" class="form-label">Estimated Delivery Date</label>
                        <input type="date" name="estimated_delivery" id="estimated_delivery" class="form-input" value="{{ old('estimated_delivery', now()->addDays(5)->format('Y-m-d')) }}" required>
                    </div>
                </div>
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="space-y-4">
                        <h4 class="text-sm font-semibold text-blue-400">Origin Location</h4>
                        <div>
                            <label class="form-label !text-xs">Country Preset</label>
                            <select id="origin_country_preset" class="form-select !py-2" onchange="updateCoordinates('origin', this.value)">
                                <option value="">-- Custom Location --</option>
                                <option value="US" selected>United States (New York)</option>
                                <option value="UK">United Kingdom (London)</option>
                                <option value="DE">Germany (Berlin)</option>
                                <option value="FR">France (Paris)</option>
                                <option value="CN">China (Beijing)</option>
                                <option value="CA">Canada (Ottawa)</option>
                                <option value="AU">Australia (Canberra)</option>
                                <option value="JP">Japan (Tokyo)</option>
                                <option value="IN">India (New Delhi)</option>
                                <option value="NG">Nigeria (Abuja)</option>
                                <option value="AE">United Arab Emirates (Abu Dhabi)</option>
                                <option value="SA">Saudi Arabia (Riyadh)</option>
                                <option value="ZA">South Africa (Cape Town)</option>
                                <option value="BR">Brazil (Brasilia)</option>
                                <option value="SG">Singapore</option>
                                <option value="TR">Turkey (Ankara)</option>
                                <option value="IT">Italy (Rome)</option>
                                <option value="ES">Spain (Madrid)</option>
                                <option value="NL">Netherlands (Amsterdam)</option>
                                <option value="BE">Belgium (Brussels)</option>
                                <option value="CH">Switzerland (Bern)</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label !text-xs">Latitude</label>
                            <input type="number" step="0.000001" name="origin_lat" id="origin_lat" class="form-input !py-2" value="{{ old('origin_lat', '40.712800') }}" required>
                        </div>
                        <div>
                            <label class="form-label !text-xs">Longitude</label>
                            <input type="number" step="0.000001" name="origin_lng" id="origin_lng" class="form-input !py-2" value="{{ old('origin_lng', '-74.006000') }}" required>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h4 class="text-sm font-semibold text-cyan-400">Destination Location</h4>
                        <div>
                            <label class="form-label !text-xs">Country Preset</label>
                            <select id="destination_country_preset" class="form-select !py-2" onchange="updateCoordinates('destination', this.value)">
                                <option value="">-- Custom Location --</option>
                                <option value="US">United States (New York)</option>
                                <option value="UK" selected>United Kingdom (London)</option>
                                <option value="DE">Germany (Berlin)</option>
                                <option value="FR">France (Paris)</option>
                                <option value="CN">China (Beijing)</option>
                                <option value="CA">Canada (Ottawa)</option>
                                <option value="AU">Australia (Canberra)</option>
                                <option value="JP">Japan (Tokyo)</option>
                                <option value="IN">India (New Delhi)</option>
                                <option value="NG">Nigeria (Abuja)</option>
                                <option value="AE">United Arab Emirates (Abu Dhabi)</option>
                                <option value="SA">Saudi Arabia (Riyadh)</option>
                                <option value="ZA">South Africa (Cape Town)</option>
                                <option value="BR">Brazil (Brasilia)</option>
                                <option value="SG">Singapore</option>
                                <option value="TR">Turkey (Ankara)</option>
                                <option value="IT">Italy (Rome)</option>
                                <option value="ES">Spain (Madrid)</option>
                                <option value="NL">Netherlands (Amsterdam)</option>
                                <option value="BE">Belgium (Brussels)</option>
                                <option value="CH">Switzerland (Bern)</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label !text-xs">Latitude</label>
                            <input type="number" step="0.000001" name="destination_lat" id="destination_lat" class="form-input !py-2" value="{{ old('destination_lat', '51.507400') }}" required>
                        </div>
                        <div>
                            <label class="form-label !text-xs">Longitude</label>
                            <input type="number" step="0.000001" name="destination_lng" id="destination_lng" class="form-input !py-2" value="{{ old('destination_lng', '-0.127800') }}" required>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h4 class="text-sm font-semibold text-emerald-400">Current Position Location</h4>
                        <div>
                            <label class="form-label !text-xs">Country Preset</label>
                            <select id="current_country_preset" class="form-select !py-2" onchange="updateCoordinates('current', this.value)">
                                <option value="">-- Custom Location --</option>
                                <option value="US" selected>United States (New York)</option>
                                <option value="UK">United Kingdom (London)</option>
                                <option value="DE">Germany (Berlin)</option>
                                <option value="FR">France (Paris)</option>
                                <option value="CN">China (Beijing)</option>
                                <option value="CA">Canada (Ottawa)</option>
                                <option value="AU">Australia (Canberra)</option>
                                <option value="JP">Japan (Tokyo)</option>
                                <option value="IN">India (New Delhi)</option>
                                <option value="NG">Nigeria (Abuja)</option>
                                <option value="AE">United Arab Emirates (Abu Dhabi)</option>
                                <option value="SA">Saudi Arabia (Riyadh)</option>
                                <option value="ZA">South Africa (Cape Town)</option>
                                <option value="BR">Brazil (Brasilia)</option>
                                <option value="SG">Singapore</option>
                                <option value="TR">Turkey (Ankara)</option>
                                <option value="IT">Italy (Rome)</option>
                                <option value="ES">Spain (Madrid)</option>
                                <option value="NL">Netherlands (Amsterdam)</option>
                                <option value="BE">Belgium (Brussels)</option>
                                <option value="CH">Switzerland (Bern)</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label !text-xs">Latitude</label>
                            <input type="number" step="0.000001" name="current_lat" id="current_lat" class="form-input !py-2" value="{{ old('current_lat', '40.712800') }}" required>
                        </div>
                        <div>
                            <label class="form-label !text-xs">Longitude</label>
                            <input type="number" step="0.000001" name="current_lng" id="current_lng" class="form-input !py-2" value="{{ old('current_lng', '-74.006000') }}" required>
                        </div>
                    </div>
                </div>
                <p class="text-xs text-slate-500 mt-4">By default, coordinates are set to New York as origin and London as destination. These are utilized on the interactive live tracking maps.</p>
            </div>

            <div class="mt-8 flex justify-end">
                <button type="submit" class="btn-primary flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Create Shipment
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
        
        // Auto-sync current position if updating origin on create page
        if (type === 'origin') {
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
</script>
@endpush

