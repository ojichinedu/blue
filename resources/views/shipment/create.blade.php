@extends('layouts.public')

@section('title', __('Send a Package'))
@section('meta_description', 'Create a new shipment with Blue Orient Logistics. Fill in your details and get a tracking number instantly.')

@section('content')

<section class="relative pt-32 pb-24 overflow-hidden">
    <div class="hero-glow top-0 right-0"></div>
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-blue-900/20 via-slate-950 to-slate-950"></div>

    <div class="relative max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold mb-4 animate-fade-in-up" style="font-family: 'Outfit', sans-serif;">
                Send a <span class="text-gradient">Package</span>
            </h1>
            <p class="text-slate-400 animate-fade-in-up delay-100">Fill in the details below and we'll handle the rest.</p>
        </div>

        {{-- Step Indicator --}}
        <div class="flex items-center justify-center mb-12 animate-fade-in-up delay-200" id="step-indicator">
            <div class="flex items-center gap-0">
                <button onclick="goToStep(1)" class="flex flex-col items-center gap-2 cursor-pointer group">
                    <div class="step-indicator step-active" id="step-dot-1">1</div>
                    <span class="text-xs text-slate-400 group-hover:text-white transition-colors hidden sm:block">Sender</span>
                </button>
                <div class="step-line w-16 sm:w-24 step-line-inactive" id="step-line-1"></div>
                <button onclick="goToStep(2)" class="flex flex-col items-center gap-2 cursor-pointer group">
                    <div class="step-indicator step-inactive" id="step-dot-2">2</div>
                    <span class="text-xs text-slate-400 group-hover:text-white transition-colors hidden sm:block">Receiver</span>
                </button>
                <div class="step-line w-16 sm:w-24 step-line-inactive" id="step-line-2"></div>
                <button onclick="goToStep(3)" class="flex flex-col items-center gap-2 cursor-pointer group">
                    <div class="step-indicator step-inactive" id="step-dot-3">3</div>
                    <span class="text-xs text-slate-400 group-hover:text-white transition-colors hidden sm:block">Package</span>
                </button>
                <div class="step-line w-16 sm:w-24 step-line-inactive" id="step-line-3"></div>
                <button onclick="goToStep(4)" class="flex flex-col items-center gap-2 cursor-pointer group">
                    <div class="step-indicator step-inactive" id="step-dot-4">4</div>
                    <span class="text-xs text-slate-400 group-hover:text-white transition-colors hidden sm:block">Review</span>
                </button>
            </div>
        </div>

        {{-- Validation Errors --}}
        @if($errors->any())
            <div class="mb-8 bg-red-500/20 border border-red-500/30 text-red-300 px-6 py-4 rounded-xl">
                <p class="font-semibold mb-2">Please fix the following errors:</p>
                <ul class="list-disc list-inside text-sm space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('shipment.store') }}" method="POST" class="glass-card p-8 lg:p-10" id="shipment-form">
            @csrf

            {{-- Step 1: Sender --}}
            <div class="step-panel" id="step-1">
                <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-3">
                    <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    Sender Information
                </h2>
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label for="sender_name" class="form-label">Full Name *</label>
                        <input type="text" name="sender_name" id="sender_name" value="{{ old('sender_name', auth()->user()->name ?? '') }}" class="form-input" required placeholder="John Doe">
                    </div>
                    <div>
                        <label for="sender_email" class="form-label">Email *</label>
                        <input type="email" name="sender_email" id="sender_email" value="{{ old('sender_email', auth()->user()->email ?? '') }}" class="form-input" required placeholder="john@example.com">
                    </div>
                    <div>
                        <label for="sender_phone" class="form-label">Phone *</label>
                        <input type="tel" name="sender_phone" id="sender_phone" value="{{ old('sender_phone') }}" class="form-input" required placeholder="+1 (555) 123-4567">
                    </div>
                    <div class="md:col-span-2">
                        <label for="sender_address" class="form-label">Address *</label>
                        <textarea name="sender_address" id="sender_address" rows="3" class="form-input" required placeholder="123 Main St, City, State, ZIP">{{ old('sender_address') }}</textarea>
                    </div>
                </div>
                <div class="flex justify-end mt-8">
                    <button type="button" onclick="nextStep()" class="btn-primary" id="step1-next">
                        Next: Receiver Details
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>

            {{-- Step 2: Receiver --}}
            <div class="step-panel hidden" id="step-2">
                <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-3">
                    <div class="w-8 h-8 bg-emerald-500/20 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    Receiver Information
                </h2>
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label for="receiver_name" class="form-label">Full Name *</label>
                        <input type="text" name="receiver_name" id="receiver_name" value="{{ old('receiver_name') }}" class="form-input" required placeholder="Jane Smith">
                    </div>
                    <div>
                        <label for="receiver_email" class="form-label">Email *</label>
                        <input type="email" name="receiver_email" id="receiver_email" value="{{ old('receiver_email') }}" class="form-input" required placeholder="jane@example.com">
                    </div>
                    <div>
                        <label for="receiver_phone" class="form-label">Phone *</label>
                        <input type="tel" name="receiver_phone" id="receiver_phone" value="{{ old('receiver_phone') }}" class="form-input" required placeholder="+44 20 7946 0958">
                    </div>
                    <div class="md:col-span-2">
                        <label for="receiver_address" class="form-label">Address *</label>
                        <textarea name="receiver_address" id="receiver_address" rows="3" class="form-input" required placeholder="456 High Street, London, UK">{{ old('receiver_address') }}</textarea>
                    </div>
                </div>
                <div class="flex justify-between mt-8">
                    <button type="button" onclick="prevStep()" class="btn-secondary" id="step2-prev">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        Back
                    </button>
                    <button type="button" onclick="nextStep()" class="btn-primary" id="step2-next">
                        Next: Package Details
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>

            {{-- Step 3: Package --}}
            <div class="step-panel hidden" id="step-3">
                <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-3">
                    <div class="w-8 h-8 bg-purple-500/20 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    Package Details
                </h2>
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label for="package_type" class="form-label">Package Type *</label>
                        <select name="package_type" id="package_type" class="form-select" required>
                            <option value="parcel" {{ old('package_type') == 'parcel' ? 'selected' : '' }}>📦 Parcel</option>
                            <option value="document" {{ old('package_type') == 'document' ? 'selected' : '' }}>📄 Document</option>
                            <option value="freight" {{ old('package_type') == 'freight' ? 'selected' : '' }}>🚛 Freight</option>
                        </select>
                    </div>
                    <div>
                        <label for="weight" class="form-label">Weight (kg)</label>
                        <input type="number" name="weight" id="weight" value="{{ old('weight') }}" class="form-input" step="0.01" min="0.01" placeholder="2.50">
                    </div>
                    <div class="md:col-span-2">
                        <label for="package_description" class="form-label">Description</label>
                        <textarea name="package_description" id="package_description" rows="3" class="form-input" placeholder="Describe the contents of your package...">{{ old('package_description') }}</textarea>
                    </div>
                </div>
                <div class="flex justify-between mt-8">
                    <button type="button" onclick="prevStep()" class="btn-secondary" id="step3-prev">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        Back
                    </button>
                    <button type="button" onclick="nextStep()" class="btn-primary" id="step3-next">
                        Next: Review
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>

            {{-- Step 4: Review --}}
            <div class="step-panel hidden" id="step-4">
                <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-3">
                    <div class="w-8 h-8 bg-amber-500/20 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    Review & Submit
                </h2>

                <div class="space-y-6">
                    {{-- Sender Summary --}}
                    <div class="bg-white/5 rounded-xl p-6 border border-white/5">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-sm font-semibold text-slate-400 uppercase tracking-wider">Sender</h3>
                            <button type="button" onclick="goToStep(1)" class="text-blue-400 text-xs hover:text-blue-300">Edit</button>
                        </div>
                        <p class="text-white" id="review-sender-name"></p>
                        <p class="text-sm text-slate-400" id="review-sender-contact"></p>
                        <p class="text-sm text-slate-400" id="review-sender-address"></p>
                    </div>

                    {{-- Receiver Summary --}}
                    <div class="bg-white/5 rounded-xl p-6 border border-white/5">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-sm font-semibold text-slate-400 uppercase tracking-wider">Receiver</h3>
                            <button type="button" onclick="goToStep(2)" class="text-blue-400 text-xs hover:text-blue-300">Edit</button>
                        </div>
                        <p class="text-white" id="review-receiver-name"></p>
                        <p class="text-sm text-slate-400" id="review-receiver-contact"></p>
                        <p class="text-sm text-slate-400" id="review-receiver-address"></p>
                    </div>

                    {{-- Package Summary --}}
                    <div class="bg-white/5 rounded-xl p-6 border border-white/5">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-sm font-semibold text-slate-400 uppercase tracking-wider">Package</h3>
                            <button type="button" onclick="goToStep(3)" class="text-blue-400 text-xs hover:text-blue-300">Edit</button>
                        </div>
                        <p class="text-white" id="review-package-type"></p>
                        <p class="text-sm text-slate-400" id="review-package-weight"></p>
                        <p class="text-sm text-slate-400" id="review-package-desc"></p>
                    </div>
                </div>

                <div class="flex justify-between mt-8">
                    <button type="button" onclick="prevStep()" class="btn-secondary" id="step4-prev">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        Back
                    </button>
                    <button type="submit" class="btn-primary" id="submit-shipment">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        {{ __('Create Shipment') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>

@endsection

@push('scripts')
<script>
    let currentStep = 1;
    const totalSteps = 4;

    function updateStepUI() {
        // Update panels
        for (let i = 1; i <= totalSteps; i++) {
            const panel = document.getElementById(`step-${i}`);
            panel.classList.toggle('hidden', i !== currentStep);
        }

        // Update dots and lines
        for (let i = 1; i <= totalSteps; i++) {
            const dot = document.getElementById(`step-dot-${i}`);
            dot.className = 'step-indicator ' + (
                i < currentStep ? 'step-completed' :
                i === currentStep ? 'step-active' : 'step-inactive'
            );
            if (i < currentStep) dot.innerHTML = '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>';
            else dot.textContent = i;
        }
        for (let i = 1; i < totalSteps; i++) {
            const line = document.getElementById(`step-line-${i}`);
            line.className = 'step-line w-16 sm:w-24 ' + (i < currentStep ? 'step-line-active' : 'step-line-inactive');
        }

        // Update review if on step 4
        if (currentStep === 4) updateReview();

        // Scroll to top of form
        document.getElementById('step-indicator').scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    function nextStep() {
        if (currentStep < totalSteps) {
            currentStep++;
            updateStepUI();
        }
    }

    function prevStep() {
        if (currentStep > 1) {
            currentStep--;
            updateStepUI();
        }
    }

    function goToStep(step) {
        currentStep = step;
        updateStepUI();
    }

    function updateReview() {
        document.getElementById('review-sender-name').textContent = document.getElementById('sender_name').value || '—';
        document.getElementById('review-sender-contact').textContent = (document.getElementById('sender_email').value || '') + ' · ' + (document.getElementById('sender_phone').value || '');
        document.getElementById('review-sender-address').textContent = document.getElementById('sender_address').value || '—';
        document.getElementById('review-receiver-name').textContent = document.getElementById('receiver_name').value || '—';
        document.getElementById('review-receiver-contact').textContent = (document.getElementById('receiver_email').value || '') + ' · ' + (document.getElementById('receiver_phone').value || '');
        document.getElementById('review-receiver-address').textContent = document.getElementById('receiver_address').value || '—';

        const typeMap = { parcel: '📦 Parcel', document: '📄 Document', freight: '🚛 Freight' };
        const typeVal = document.getElementById('package_type').value;
        document.getElementById('review-package-type').textContent = typeMap[typeVal] || typeVal;
        const weight = document.getElementById('weight').value;
        document.getElementById('review-package-weight').textContent = weight ? weight + ' kg' : 'Not specified';
        document.getElementById('review-package-desc').textContent = document.getElementById('package_description').value || 'No description';
    }
</script>
@endpush
