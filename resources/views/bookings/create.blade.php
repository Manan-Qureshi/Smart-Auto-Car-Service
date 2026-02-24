@extends('layouts.app')
@section('content')
<div class="container py-4" style="max-width:680px">
    <div class="glass-card p-4 rounded-4 shadow">
        {{-- Header --}}
        <div class="d-flex align-items-center gap-3 mb-4">
            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white" style="width:48px;height:48px;font-size:1.2rem">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div>
                <h4 class="fw-bold mb-0">Book Service</h4>
                <small class="text-muted">{{ $provider->business_name }}</small>
            </div>
        </div>

        {{-- Service & Price Summary --}}
        {{-- Services & Price Summary --}}
        <div class="rounded-3 p-3 mb-4" style="background:linear-gradient(135deg,#667eea22,#764ba222); border:1px solid #667eea33">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="fw-bold">Cart Items</div>
                <small class="text-muted">
                    <i class="fas fa-clock me-1"></i>{{ $totalDuration }} min total
                </small>
            </div>
            <ul class="list-unstyled small mb-3 ps-3" style="border-left:2px solid #667eea">
                @foreach($services as $srv)
                    <li><i class="fas fa-check text-primary me-2"></i>{{ $srv->name }}</li>
                @endforeach
            </ul>
            <div class="d-flex justify-content-between align-items-end mt-2 pt-2 border-top">
                <small class="text-muted">
                    @if($selectedCar)
                        Car: {{ $selectedCar['type_name'] }} — {{ $selectedCar['name'] }}
                    @endif
                </small>
                <div class="text-end">
                    <div class="fs-5 fw-bold text-primary">PKR {{ number_format($finalPrice) }}</div>
                    <small class="text-muted">Online payment only</small>
                </div>
            </div>
        </div>

        {{-- Provider Hours --}}
        <div class="alert alert-info rounded-3 py-2 px-3 small mb-4">
            <i class="fas fa-store me-2"></i>
            <strong>Working hours:</strong>
            {{ \Carbon\Carbon::parse($provider->open_time ?? '08:00')->format('h:i A') }}
            &ndash;
            {{ \Carbon\Carbon::parse($provider->close_time ?? '18:00')->format('h:i A') }}
        </div>

        <form action="{{ route('bookings.store') }}" method="POST" id="bookingForm">
            @csrf
            @foreach($services as $srv)
                <input type="hidden" name="service_ids[]" value="{{ $srv->id }}">
            @endforeach
            <input type="hidden" name="service_provider_id" value="{{ $provider->id }}">
            @if($selectedCar)
                <input type="hidden" name="car_model_id" value="{{ $selectedCar['id'] }}">
            @endif
            <input type="hidden" name="appointment_date" id="hiddenDate">
            <input type="hidden" name="appointment_time" id="hiddenTime">

            {{-- Day Selector --}}
            <div class="mb-4">
                <label class="form-label fw-semibold">Select Day <span class="text-danger">*</span></label>
                <div class="d-flex gap-3">
                    @php
                        $today    = \Carbon\Carbon::today();
                        $tomorrow = \Carbon\Carbon::tomorrow();
                    @endphp
                    <button type="button" id="btnToday"
                        class="btn btn-outline-primary rounded-pill flex-grow-1 py-3 day-btn"
                        data-date="{{ $today->format('Y-m-d') }}">
                        <i class="fas fa-sun me-2"></i>
                        <strong>Today</strong><br>
                        <small class="text-muted">{{ $today->format('D, d M') }}</small>
                    </button>
                    <button type="button" id="btnTomorrow"
                        class="btn btn-outline-primary rounded-pill flex-grow-1 py-3 day-btn"
                        data-date="{{ $tomorrow->format('Y-m-d') }}">
                        <i class="fas fa-moon me-2"></i>
                        <strong>Tomorrow</strong><br>
                        <small class="text-muted">{{ $tomorrow->format('D, d M') }}</small>
                    </button>
                </div>
            </div>

            {{-- Time Slot Selector --}}
            <div class="mb-4" id="slotSection" style="display:none">
                <label class="form-label fw-semibold">Available Time Slots <span class="text-danger">*</span></label>
                <div id="slotLoading" class="text-muted small mb-2" style="display:none">
                    <i class="fas fa-spinner fa-spin me-1"></i> Loading slots...
                </div>
                <div id="slotGrid" class="d-flex flex-wrap gap-2"></div>
                <div id="slotEmpty" class="text-muted small" style="display:none">
                    <i class="fas fa-calendar-times me-1"></i> No slots available for this day.
                </div>
                <input type="hidden" id="selectedSlot">
            </div>

            {{-- Notes --}}
            <div class="mb-4">
                <label class="form-label fw-semibold">Notes <span class="text-muted">(optional)</span></label>
                <textarea name="notes" class="form-control rounded-3" rows="3"
                          placeholder="Any special instructions...">{{ old('notes') }}</textarea>
            </div>

            <hr class="my-4">

            {{-- Payment info --}}
            <div class="d-flex align-items-center gap-3 p-3 rounded-3 bg-light mb-4">
                <i class="fab fa-stripe fa-2x text-primary"></i>
                <div>
                    <div class="fw-semibold small">Secure Online Payment via Stripe</div>
                    <div class="text-muted small">You'll be redirected to Stripe's secure checkout page.</div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('providers.show', $provider) }}" class="btn btn-outline-secondary rounded-pill flex-grow-1">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
                <button type="submit" class="btn btn-primary rounded-pill flex-grow-1" id="submitBtn" disabled>
                    <i class="fas fa-lock me-1"></i> Proceed to Payment — PKR {{ number_format($finalPrice) }}
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
const PROVIDER_ID = {{ $provider->id }};
const DURATION    = {{ $totalDuration }};
let selectedDate  = null;
let selectedTime  = null;

document.querySelectorAll('.day-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        document.querySelectorAll('.day-btn').forEach(b => b.classList.remove('active', 'btn-primary'));
        this.classList.add('active', 'btn-primary');
        this.classList.remove('btn-outline-primary');
        document.querySelectorAll('.day-btn:not(.active)').forEach(b => b.classList.add('btn-outline-primary'));

        selectedDate = this.dataset.date;
        document.getElementById('hiddenDate').value = selectedDate;

        // Reset slot selection
        selectedTime = null;
        document.getElementById('hiddenTime').value = '';
        document.getElementById('submitBtn').disabled = true;

        loadSlots(selectedDate);
    });
});

function loadSlots(date) {
    const section = document.getElementById('slotSection');
    const grid    = document.getElementById('slotGrid');
    const loading = document.getElementById('slotLoading');
    const empty   = document.getElementById('slotEmpty');

    section.style.display = 'block';
    loading.style.display = 'block';
    grid.innerHTML = '';
    empty.style.display = 'none';

    fetch(`/api/timeslots?provider_id=${PROVIDER_ID}&date=${date}&duration=${DURATION}`)
        .then(r => r.json())
        .then(slots => {
            loading.style.display = 'none';
            if (!slots.length) {
                empty.style.display = 'block';
                return;
            }
            slots.forEach(slot => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'btn btn-outline-secondary rounded-pill slot-btn px-3';
                btn.textContent = formatTime(slot);
                btn.dataset.time = slot;
                btn.addEventListener('click', function () {
                    document.querySelectorAll('.slot-btn').forEach(b => {
                        b.classList.remove('btn-primary', 'active');
                        b.classList.add('btn-outline-secondary');
                    });
                    this.classList.remove('btn-outline-secondary');
                    this.classList.add('btn-primary', 'active');
                    selectedTime = this.dataset.time;
                    document.getElementById('hiddenTime').value = selectedTime;
                    document.getElementById('submitBtn').disabled = false;
                });
                grid.appendChild(btn);
            });
        })
        .catch(() => {
            loading.style.display = 'none';
            empty.textContent = 'Could not load slots. Please try again.';
            empty.style.display = 'block';
        });
}

function formatTime(t) {
    const [h, m] = t.split(':').map(Number);
    const ampm = h >= 12 ? 'PM' : 'AM';
    const hh   = h % 12 || 12;
    return `${hh}:${String(m).padStart(2,'0')} ${ampm}`;
}

// Prevent form submit if day/time not selected
document.getElementById('bookingForm').addEventListener('submit', function(e) {
    if (!selectedDate || !selectedTime) {
        e.preventDefault();
        alert('Please select a day and time slot.');
    }
});
</script>
@endpush
@endsection