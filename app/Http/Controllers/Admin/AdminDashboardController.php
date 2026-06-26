<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Models\ShipmentUpdate;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_shipments' => Shipment::count(),
            'in_transit' => Shipment::where('status', 'in_transit')->count(),
            'delivered_today' => Shipment::where('status', 'delivered')
                ->whereDate('actual_delivery', today())
                ->count(),
            'pending' => Shipment::where('status', 'pending')->count(),
            'total_users' => User::where('is_admin', false)->count(),
        ];

        $recentShipments = Shipment::with('user')->latest()->take(10)->get();

        $statusCounts = [
            'pending' => Shipment::where('status', 'pending')->count(),
            'picked_up' => Shipment::where('status', 'picked_up')->count(),
            'in_transit' => Shipment::where('status', 'in_transit')->count(),
            'out_for_delivery' => Shipment::where('status', 'out_for_delivery')->count(),
            'delivered' => Shipment::where('status', 'delivered')->count(),
            'cancelled' => Shipment::where('status', 'cancelled')->count(),
        ];

        return view('admin.index', compact('stats', 'recentShipments', 'statusCounts'));
    }

    public function shipments(Request $request)
    {
        $query = Shipment::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('tracking_number', 'like', "%{$search}%")
                  ->orWhere('sender_name', 'like', "%{$search}%")
                  ->orWhere('receiver_name', 'like', "%{$search}%");
            });
        }

        $shipments = $query->paginate(15);

        return view('admin.shipments', compact('shipments'));
    }

    public function showShipment($id)
    {
        $shipment = Shipment::with(['updates', 'user'])->findOrFail($id);

        return view('admin.shipment-detail', compact('shipment'));
    }

    public function updateShipment(Request $request, $id)
    {
        $shipment = Shipment::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:pending,picked_up,in_transit,out_for_delivery,delivered,cancelled',
            'current_lat' => 'nullable|numeric|between:-90,90',
            'current_lng' => 'nullable|numeric|between:-180,180',
            'note' => 'nullable|string|max:500',
        ]);

        $shipment->update([
            'status' => $validated['status'],
            'current_lat' => $validated['current_lat'],
            'current_lng' => $validated['current_lng'],
        ]);

        if ($validated['status'] === 'delivered' && !$shipment->actual_delivery) {
            $shipment->update(['actual_delivery' => now()]);
        }

        // Determine custom location name based on status
        $locationName = 'In Transit';
        if ($validated['status'] === 'pending') {
            $locationName = 'Origin Hub';
        } elseif ($validated['status'] === 'picked_up') {
            $locationName = 'Sender Location';
        } elseif ($validated['status'] === 'out_for_delivery') {
            $locationName = 'Local Distribution Center';
        } elseif ($validated['status'] === 'delivered') {
            $locationName = 'Receiver Address';
        }

        // Create shipment update entry
        ShipmentUpdate::create([
            'shipment_id' => $shipment->id,
            'status' => $validated['status'],
            'location_name' => $locationName,
            'description' => $validated['note'] ?? 'Shipment status updated to ' . str_replace('_', ' ', $validated['status']),
            'lat' => $validated['current_lat'],
            'lng' => $validated['current_lng'],
            'update_time' => now(),
        ]);

        return back()->with('success', 'Shipment updated and tracking entry logged successfully.');
    }

    public function addUpdate(Request $request, $id)
    {
        $shipment = Shipment::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|string|max:255',
            'location_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'lat' => 'nullable|numeric|between:-90,90',
            'lng' => 'nullable|numeric|between:-180,180',
        ]);

        $validated['shipment_id'] = $shipment->id;
        $validated['update_time'] = now();

        ShipmentUpdate::create($validated);

        // Update shipment current position
        if ($validated['lat'] && $validated['lng']) {
            $shipment->update([
                'current_lat' => $validated['lat'],
                'current_lng' => $validated['lng'],
            ]);
        }

        // Update shipment status
        $statusMap = [
            'pending' => 'pending',
            'picked_up' => 'picked_up',
            'picked up' => 'picked_up',
            'in transit' => 'in_transit',
            'in_transit' => 'in_transit',
            'out for delivery' => 'out_for_delivery',
            'out_for_delivery' => 'out_for_delivery',
            'delivered' => 'delivered',
            'cancelled' => 'cancelled',
        ];

        $normalizedStatus = strtolower($validated['status']);
        if (isset($statusMap[$normalizedStatus])) {
            $shipment->update(['status' => $statusMap[$normalizedStatus]]);
        }

        return back()->with('success', 'Tracking update added successfully.');
    }

    public function destroyShipment($id)
    {
        $shipment = Shipment::findOrFail($id);
        
        $shipment->updates()->delete();
        $shipment->delete();

        return redirect()->route('admin.shipments')->with('success', 'Shipment deleted successfully.');
    }
}
