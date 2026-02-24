@extends('layouts.app')

@section('content')
    <div class="container fade-in-up">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="glass-card p-4">
                    <div class="d-flex align-items-center mb-4 border-bottom border-light pb-3">
                        <i class="fas fa-file-invoice-dollar fa-2x me-3 text-primary"></i>
                        <h3 class="m-0">Custom Proposal Approval</h3>
                    </div>

                    <!-- Proposal Summary -->
                    <div class="card bg-transparent border-0 mb-4">
                        <div class="card-body p-0">
                            <h5 class="text-light mb-3">Service Details</h5>
                            <div class="glass-card p-4 mb-3" style="background: rgba(255,255,255,0.05);">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h4 class="text-primary fw-bold mb-0">{{ $booking->service->name }}</h4>
                                    <span class="fs-4 fw-bold text-white">PKR {{ number_format($booking->final_price, 2) }}</span>
                                </div>
                                <p class="text-muted mb-3">{{ $booking->service->description }}</p>
                                <div class="d-flex align-items-center text-muted small">
                                    <i class="fas fa-history me-1"></i>
                                    <span>Estimated Time: {{ $booking->service->duration_minutes }} mins</span>
                                    <span class="mx-2">|</span>
                                    <i class="fas fa-car me-1"></i>
                                    <span>Vehicle: {{ $booking->carModel->name }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('bookings.proposal.confirm', $booking->id) }}">
                        @csrf
                        
                        <!-- Slot Selection -->
                        <h5 class="mb-3 text-light border-bottom border-light pb-2">Step 1: Choose Your Schedule</h5>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="appointment_date" class="form-label text-light">Select Date</label>
                                <select id="appointment_date" name="appointment_date" class="form-select" required>
                                    <option value="" disabled selected>Select Date</option>
                                    <option value="{{ date('Y-m-d') }}">Today ({{ date('M d') }})</option>
                                    <option value="{{ date('Y-m-d', strtotime('+1 day')) }}">Tomorrow ({{ date('M d', strtotime('+1 day')) }})</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="appointment_time" class="form-label text-light">Available Slots</label>
                                <select id="appointment_time" name="appointment_time" class="form-select" required disabled>
                                    <option value="">Select Date First</option>
                                </select>
                            </div>
                        </div>

                        <!-- Payment Method Selection -->
                        <h5 class="mb-3 text-light border-bottom border-light pb-2">Step 2: Payment Method</h5>
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <div class="glass-card p-3 border border-primary h-100 selection-card" style="cursor: pointer; background: rgba(255,255,255,0.02);">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method" id="pay_online" value="online" checked>
                                        <label class="form-check-label d-block cursor-pointer" for="pay_online">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-credit-card fa-2x me-3 text-primary"></i>
                                                <div>
                                                    <span class="d-block fw-bold text-light">Online Payment</span>
                                                    <small class="text-muted">Pay securely via Stripe</small>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="glass-card p-3 border border-light h-100 selection-card" style="cursor: pointer; background: rgba(255,255,255,0.02);">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method" id="pay_cod" value="cod">
                                        <label class="form-check-label d-block cursor-pointer" for="pay_cod">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-money-bill-wave fa-2x me-3 text-success"></i>
                                                <div>
                                                    <span class="d-block fw-bold text-light">Cash on Delivery</span>
                                                    <small class="text-muted">Pay after service completion</small>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" id="submit-btn"
                            class="btn btn-primary w-100 py-3 fw-bold rounded-pill text-uppercase letter-spacing-1">
                            <i class="fas fa-check-circle me-2"></i> Approve Proposal & Pay
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // CSRF Setup for AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Fetch Available Slots
            function fetchSlots() {
                var date = $('#appointment_date').val();
                var duration = {{ $booking->service->duration_minutes }}; 
                var $timeSelect = $('#appointment_time');

                if (!date) return;
                
                $timeSelect.empty().append('<option value="">Loading slots...</option>').prop('disabled', true);

                $.get('/api/slots', { date: date, duration: duration })
                    .done(function (data) {
                        $timeSelect.empty().append('<option value="">Select Time Slot</option>');

                        var validSlots = [];
                        var selectedDateStr = date;
                        var now = new Date(); 

                        var todayStr = now.getFullYear() + '-' + String(now.getMonth() + 1).padStart(2, '0') + '-' + String(now.getDate()).padStart(2, '0');
                        var isToday = (selectedDateStr === todayStr);
                        var cutoffTime = new Date(now.getTime() + 20 * 60000); // +20 mins

                        if (data.available_slots) {
                            $.each(data.available_slots, function (index, slot) {
                                if (isToday) {
                                    var parts = slot.split(':');
                                    var slotDate = new Date(now);
                                    slotDate.setHours(parseInt(parts[0]), parseInt(parts[1]), 0, 0);

                                    if (slotDate > cutoffTime) {
                                        validSlots.push(slot);
                                    }
                                } else {
                                    validSlots.push(slot);
                                }
                            });
                        }

                        if (validSlots.length > 0) {
                            $.each(validSlots, function (index, slot) {
                                $timeSelect.append('<option value="' + slot + '">' + slot + '</option>');
                            });
                            $timeSelect.prop('disabled', false);
                        } else {
                            $timeSelect.append('<option value="">No slots available</option>');
                        }
                    })
                    .fail(function() {
                        $timeSelect.empty().append('<option value="">Error loading slots</option>');
                    });
            }

            $('#appointment_date').change(fetchSlots);

            // Payment Method Selection UI
            $('input[name="payment_method"]').change(function() {
                var val = $(this).val();
                
                // Reset styles
                $('.selection-card').removeClass('border-primary').addClass('border-light');
                
                // Highlight selected
                $(this).closest('.selection-card').removeClass('border-light').addClass('border-primary');

                // Update button text
                if (val === 'cod') {
                    $('#submit-btn').html('<i class="fas fa-check-circle me-2"></i> Approve Proposal (COD)');
                } else {
                    $('#submit-btn').html('<i class="fas fa-lock me-2"></i> Approve & Pay via Stripe');
                }
            });

            // Make entire card clickable for radio selection
            $('.selection-card').click(function() {
                $(this).find('input[type="radio"]').prop('checked', true).trigger('change');
            });
        });
    </script>
@endsection
