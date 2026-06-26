@extends('layouts.admin')

@section('title', 'Create Receipt')
@section('page_title', 'Create Receipt for ' . $shipment->tracking_number)

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('admin.shipment.show', $shipment->id) }}" class="btn-secondary btn-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Shipment
        </a>
    </div>

    <div class="glass-card p-8">
        {{-- Shipment Summary --}}
        <div class="mb-8 p-4 bg-white/5 border border-white/10 rounded-xl">
            <h4 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Shipment Summary</h4>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-slate-500 block text-xs">Tracking Number</span>
                    <span class="text-white font-mono">{{ $shipment->tracking_number }}</span>
                </div>
                <div>
                    <span class="text-slate-500 block text-xs">Package Type</span>
                    <span class="text-white capitalize">{{ $shipment->package_type }} ({{ $shipment->weight ?? '—' }} kg)</span>
                </div>
                <div>
                    <span class="text-slate-500 block text-xs">Sender</span>
                    <span class="text-white">{{ $shipment->sender_name }}</span>
                </div>
                <div>
                    <span class="text-slate-500 block text-xs">Receiver</span>
                    <span class="text-white">{{ $shipment->receiver_name }}</span>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.receipt.store', $shipment->id) }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid md:grid-cols-2 gap-6">
                {{-- Amount (USD) --}}
                <div class="md:col-span-2">
                    <label for="amount" class="form-label">Receipt Amount (USD) *</label>
                    <div class="relative rounded-xl shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <span class="text-slate-500 sm:text-sm">$</span>
                        </div>
                        <input type="number" name="amount" id="amount" step="0.01" min="0" class="form-input !pl-8" placeholder="0.00" value="{{ old('amount') }}" required>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <span class="text-slate-500 sm:text-sm">USD</span>
                        </div>
                    </div>
                </div>

                {{-- Payment Method --}}
                <div>
                    <label for="payment_method" class="form-label">Payment Method *</label>
                    <div class="relative">
                        <select name="payment_method" id="payment_method" class="form-select" required>
                            <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                            <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            <option value="paypal" {{ old('payment_method') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                            <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="crypto" {{ old('payment_method') == 'crypto' ? 'selected' : '' }}>Cryptocurrency</option>
                            <option value="other" {{ old('payment_method') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>

                {{-- Payment Status --}}
                <div>
                    <label for="payment_status" class="form-label">Payment Status *</label>
                    <div class="relative">
                        <select name="payment_status" id="payment_status" class="form-select" required>
                            <option value="pending" {{ old('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ old('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="unpaid" {{ old('payment_status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Notes --}}
            <div>
                <label for="notes" class="form-label">Billing Notes / Description (Optional)</label>
                <textarea name="notes" id="notes" rows="4" class="form-input" placeholder="e.g. Shipping fees, customs handling charges, express delivery markup">{{ old('notes') }}</textarea>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="btn-primary flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Generate Receipt
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
