<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\ShipmentUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShipmentController extends Controller
{
    public function create()
    {
        return view('shipment.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sender_name' => 'required|string|max:255',
            'sender_email' => 'required|email|max:255',
            'sender_phone' => 'required|string|max:20',
            'sender_address' => 'required|string|max:500',
            'receiver_name' => 'required|string|max:255',
            'receiver_email' => 'required|email|max:255',
            'receiver_phone' => 'required|string|max:20',
            'receiver_address' => 'required|string|max:500',
            'package_description' => 'nullable|string|max:500',
            'weight' => 'nullable|numeric|min:0.01|max:9999',
            'package_type' => 'required|in:document,parcel,freight',
        ]);

        $validated['user_id'] = Auth::id();

        // Default coordinates (will be updated by admin)
        $validated['origin_lat'] = $request->input('origin_lat', 40.7128);
        $validated['origin_lng'] = $request->input('origin_lng', -74.0060);
        $validated['destination_lat'] = $request->input('destination_lat', 51.5074);
        $validated['destination_lng'] = $request->input('destination_lng', -0.1278);
        $validated['current_lat'] = $validated['origin_lat'];
        $validated['current_lng'] = $validated['origin_lng'];
        $validated['estimated_delivery'] = now()->addDays(rand(3, 7));

        $shipment = Shipment::create($validated);

        // Create initial tracking update
        ShipmentUpdate::create([
            'shipment_id' => $shipment->id,
            'status' => 'pending',
            'location_name' => 'Origin Hub',
            'description' => 'Shipment has been registered and is awaiting pickup.',
            'lat' => $shipment->origin_lat,
            'lng' => $shipment->origin_lng,
            'update_time' => now(),
        ]);

        return redirect()->route('track.result', $shipment->tracking_number)
            ->with('success', 'Shipment created successfully! Your tracking number is: ' . $shipment->tracking_number);
    }

    public function track()
    {
        return view('shipment.track');
    }

    public function trackResult($trackingNumber)
    {
        $shipment = Shipment::with('updates')
            ->byTrackingNumber($trackingNumber)
            ->firstOrFail();

        return view('shipment.track-result', compact('shipment'));
    }

    public function getPosition($trackingNumber)
    {
        $shipment = Shipment::with('updates')
            ->byTrackingNumber($trackingNumber)
            ->firstOrFail();

        return response()->json([
            'tracking_number' => $shipment->tracking_number,
            'status' => $shipment->status,
            'status_label' => $shipment->status_label,
            'current_lat' => (float) $shipment->current_lat,
            'current_lng' => (float) $shipment->current_lng,
            'origin' => [
                'lat' => (float) $shipment->origin_lat,
                'lng' => (float) $shipment->origin_lng,
            ],
            'destination' => [
                'lat' => (float) $shipment->destination_lat,
                'lng' => (float) $shipment->destination_lng,
            ],
            'waypoints' => $shipment->updates->map(fn($u) => [
                'lat' => (float) $u->lat,
                'lng' => (float) $u->lng,
                'status' => $u->status,
                'location' => $u->location_name,
                'description' => $u->description,
                'time' => $u->update_time->toIso8601String(),
            ])->toArray(),
            'updated_at' => $shipment->updated_at->toIso8601String(),
        ]);
    }
}
