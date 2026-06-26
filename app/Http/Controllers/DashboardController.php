<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Shipment::forUser(Auth::id())->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('tracking_number', 'like', '%' . $request->search . '%');
        }

        $shipments = $query->paginate(10);

        $stats = [
            'total' => Shipment::forUser(Auth::id())->count(),
            'in_transit' => Shipment::forUser(Auth::id())->where('status', 'in_transit')->count(),
            'delivered' => Shipment::forUser(Auth::id())->where('status', 'delivered')->count(),
            'pending' => Shipment::forUser(Auth::id())->where('status', 'pending')->count(),
        ];

        return view('dashboard.index', compact('shipments', 'stats'));
    }

    public function show($id)
    {
        $shipment = Shipment::with('updates')
            ->forUser(Auth::id())
            ->findOrFail($id);

        return view('dashboard.shipment', compact('shipment'));
    }
}
