<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Receipt;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReceiptController extends Controller
{
    public function create($shipmentId)
    {
        $shipment = Shipment::findOrFail($shipmentId);
        
        // If shipment already has a receipt, redirect back
        if ($shipment->receipt) {
            return redirect()->route('admin.shipment.show', $shipment->id)
                ->with('error', 'Shipment already has a receipt.');
        }

        return view('admin.receipt.create', compact('shipment'));
    }

    public function store(Request $request, $shipmentId)
    {
        $shipment = Shipment::findOrFail($shipmentId);

        if ($shipment->receipt) {
            return redirect()->route('admin.shipment.show', $shipment->id)
                ->with('error', 'Shipment already has a receipt.');
        }

        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|in:credit_card,bank_transfer,paypal,cash,crypto,other',
            'payment_status' => 'required|string|in:paid,pending,unpaid',
            'notes' => 'nullable|string|max:1000',
        ]);

        $validated['shipment_id'] = $shipment->id;

        Receipt::create($validated);

        return redirect()->route('admin.shipment.show', $shipment->id)
            ->with('success', 'Receipt created successfully.');
    }

    public function edit($id)
    {
        $receipt = Receipt::with('shipment')->findOrFail($id);
        return view('admin.receipt.edit', compact('receipt'));
    }

    public function update(Request $request, $id)
    {
        $receipt = Receipt::findOrFail($id);

        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|in:credit_card,bank_transfer,paypal,cash,crypto,other',
            'payment_status' => 'required|string|in:paid,pending,unpaid',
            'notes' => 'nullable|string|max:1000',
        ]);

        $receipt->update($validated);

        return redirect()->route('admin.shipment.show', $receipt->shipment_id)
            ->with('success', 'Receipt updated successfully.');
    }

    public function destroy($id)
    {
        $receipt = Receipt::findOrFail($id);
        $shipmentId = $receipt->shipment_id;
        
        $receipt->delete();

        return redirect()->route('admin.shipment.show', $shipmentId)
            ->with('success', 'Receipt deleted successfully.');
    }

    public function show($id)
    {
        $receipt = Receipt::with('shipment')->findOrFail($id);
        $isAdmin = true;
        return view('admin.receipt.show', compact('receipt', 'isAdmin'));
    }

    public function showClient($id)
    {
        $receipt = Receipt::with('shipment')->findOrFail($id);

        // Security check: client must own this shipment
        if ($receipt->shipment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this receipt.');
        }

        $isAdmin = false;
        return view('admin.receipt.show', compact('receipt', 'isAdmin'));
    }
}
