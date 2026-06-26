<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Receipt - {{ $receipt->receipt_number }}</title>
    <!-- Outfit & Inter Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700|outfit:400,500,600,700,800&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Light style by default for printable receipt, premium looking */
        body {
            background-color: #f8fafc;
            color: #0f172a;
            font-family: 'Inter', sans-serif;
        }
        
        .invoice-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            border-radius: 1.5rem;
        }

        .badge-invoice-paid {
            background-color: #d1fae5;
            color: #064e3b;
            border: 1px solid #a7f3d0;
        }
        .badge-invoice-pending {
            background-color: #fef9c3;
            color: #713f12;
            border: 1px solid #fef08a;
        }
        .badge-invoice-unpaid {
            background-color: #fee2e2;
            color: #7f1d1d;
            border: 1px solid #fca5a5;
        }

        @media print {
            body {
                background-color: #ffffff !important;
                color: #000000 !important;
                padding-top: 0 !important;
                padding-bottom: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            .invoice-card {
                border: none !important;
                box-shadow: none !important;
                border-radius: 0 !important;
                padding: 0 !important;
                margin: 0 !important;
            }
        }
    </style>
</head>
<body class="antialiased min-h-screen py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6">
        
        {{-- Navigation / Actions --}}
        <div class="mb-8 flex justify-between items-center no-print">
            @if($isAdmin)
                <a href="{{ route('admin.shipment.show', $receipt->shipment_id) }}" class="btn-secondary btn-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Shipment
                </a>
            @else
                <a href="{{ route('dashboard.shipment', $receipt->shipment_id) }}" class="btn-secondary btn-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Dashboard
                </a>
            @endif
            
            <button onclick="window.print()" class="btn-primary btn-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Print / Save as PDF
            </button>
        </div>

        {{-- Invoice Card --}}
        <div class="invoice-card p-8 sm:p-12">
            {{-- Header --}}
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-slate-100 pb-8 gap-6">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-cyan-500 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/25">
                        <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-xl font-bold bg-gradient-to-r from-blue-600 to-cyan-500 bg-clip-text text-transparent" style="font-family: 'Outfit', sans-serif;">Blue Orient Logistics</span>
                        <span class="block text-xs text-slate-500">Official Payment Receipt</span>
                    </div>
                </div>
                <div class="text-left sm:text-right">
                    <span class="block text-xs text-slate-400 uppercase tracking-wider">Receipt Number</span>
                    <span class="text-lg font-bold font-mono text-slate-900">{{ $receipt->receipt_number }}</span>
                </div>
            </div>

            {{-- Info Rows --}}
            <div class="grid sm:grid-cols-2 gap-8 py-8 border-b border-slate-100 text-sm">
                <div>
                    <span class="block text-xs text-slate-400 uppercase tracking-wider mb-2">Billing Information</span>
                    <p class="font-semibold text-slate-800">{{ $receipt->shipment->sender_name }}</p>
                    <p class="text-slate-500 mt-0.5">{{ $receipt->shipment->sender_email }}</p>
                    <p class="text-slate-500">{{ $receipt->shipment->sender_phone }}</p>
                    <p class="text-slate-500 mt-1.5 whitespace-pre-line leading-relaxed">{{ $receipt->shipment->sender_address }}</p>
                </div>
                <div class="sm:text-right">
                    <span class="block text-xs text-slate-400 uppercase tracking-wider mb-2">Receipt Details</span>
                    <div class="space-y-1.5">
                        <div class="flex sm:justify-end gap-4"><span class="text-slate-400">Date Issued:</span> <span class="font-medium text-slate-700">{{ $receipt->created_at->format('M d, Y') }}</span></div>
                        <div class="flex sm:justify-end gap-4"><span class="text-slate-400">Tracking Ref:</span> <span class="font-medium font-mono text-slate-700">{{ $receipt->shipment->tracking_number }}</span></div>
                        <div class="flex sm:justify-end gap-4"><span class="text-slate-400">Payment Status:</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $receipt->payment_status === 'paid' ? 'badge-invoice-paid' : ($receipt->payment_status === 'pending' ? 'badge-invoice-pending' : 'badge-invoice-unpaid') }}">
                                {{ ucfirst($receipt->payment_status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Shipping/Delivery Addresses --}}
            <div class="grid sm:grid-cols-2 gap-8 py-8 border-b border-slate-100 text-sm">
                <div>
                    <span class="block text-xs text-slate-400 uppercase tracking-wider mb-2">Origin</span>
                    <p class="font-medium text-slate-700">{{ $receipt->shipment->sender_name }}</p>
                    <p class="text-slate-500 mt-1 leading-relaxed">{{ $receipt->shipment->sender_address }}</p>
                </div>
                <div>
                    <span class="block text-xs text-slate-400 uppercase tracking-wider mb-2">Destination</span>
                    <p class="font-medium text-slate-700">{{ $receipt->shipment->receiver_name }}</p>
                    <p class="text-slate-500 mt-1 leading-relaxed">{{ $receipt->shipment->receiver_address }}</p>
                </div>
            </div>

            {{-- Itemized Table --}}
            <div class="py-8">
                <span class="block text-xs text-slate-400 uppercase tracking-wider mb-4">Shipment Details & Fees</span>
                <div class="overflow-hidden border border-slate-100 rounded-xl">
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100 text-xs font-semibold text-slate-500 uppercase">
                                <th class="px-6 py-4">Description</th>
                                <th class="px-6 py-4">Type</th>
                                <th class="px-6 py-4">Weight</th>
                                <th class="px-6 py-4 text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            <tr>
                                <td class="px-6 py-5">
                                    <p class="font-semibold text-slate-800">Logistics Services</p>
                                    @if($receipt->notes)
                                        <p class="text-xs text-slate-400 mt-1 font-medium">{{ $receipt->notes }}</p>
                                    @else
                                        <p class="text-xs text-slate-400 mt-1">Standard freight & handling fees for tracking reference {{ $receipt->shipment->tracking_number }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-5 capitalize">{{ $receipt->shipment->package_type }}</td>
                                <td class="px-6 py-5">{{ $receipt->shipment->weight ? $receipt->shipment->weight . ' kg' : '—' }}</td>
                                <td class="px-6 py-5 text-right font-medium">${{ number_format($receipt->amount, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Total Block --}}
            <div class="flex justify-end pt-4">
                <div class="w-full sm:w-64 text-sm space-y-3">
                    <div class="flex justify-between text-slate-500">
                        <span>Payment Method:</span>
                        <span class="font-medium text-slate-800 capitalize">{{ str_replace('_', ' ', $receipt->payment_method) }}</span>
                    </div>
                    <div class="flex justify-between border-t border-slate-100 pt-3 text-base font-bold text-slate-900">
                        <span>Total Paid:</span>
                        <span class="text-lg text-emerald-600">${{ number_format($receipt->amount, 2) }} USD</span>
                    </div>
                </div>
            </div>

            {{-- Footer Notes --}}
            <div class="mt-16 pt-8 border-t border-slate-100 text-center text-xs text-slate-400 leading-relaxed">
                <p>Thank you for choosing Blue Orient Logistics for your global shipping needs.</p>
                <p class="mt-1">If you have any questions regarding this receipt, please contact support at support@blueorientlogistics.org.</p>
            </div>
        </div>
        
    </div>
</body>
</html>
