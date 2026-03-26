@extends('layouts.frontend')

@section('content')

    {{-- â”€â”€ HERO SECTION â”€â”€ --}}
    <section class="sacs-hero">
        <div class="sacs-hero__inner">

            {{-- Left Text Column --}}
            <div class="sacs-hero__text">

                <h1 class="sacs-hero__title">
                    Best Car Repair &amp;<br>Maintenance Services
                </h1>

                <p class="sacs-hero__subtitle">
                    Connect with certified mechanics near you. Fast, transparent and reliable car care. Exactly when you
                    need it.
                </p>

            </div>

            {{-- Right Car Image Column --}}
            <div class="sacs-hero__visual">
                {{-- Decorative blob --}}
                <div class="sacs-hero__blob"></div>

                {{-- Car image --}}
                <img src="{{ asset('images/car_exploded.png') }}"
                    onerror="this.src='https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=700&q=80'; this.style.objectFit='cover';"
                    alt="Car" class="sacs-hero__car-img">

                {{-- â”€â”€ FIND NEAREST PROVIDER BUTTON (right below the car) â”€â”€ --}}
                <div class="sacs-hero__geo-wrap">
                    <button id="findNearestBtn" class="sacs-hero__geo-btn">
                        <i class="fas fa-location-crosshairs me-2"></i>
                        Find Nearest Provider
                    </button>
                    <p id="geoStatus" class="sacs-hero__geo-status"></p>
                </div>
            </div>

        </div>
    </section>

    {{-- â”€â”€ PROVIDERS SECTION (shown only after location detected) â”€â”€ --}}
    <section class="sacs-providers" id="providersSection">
        <div class="sacs-providers__inner">
            @if($lat && $lng)
                <h2 class="sacs-providers__heading">
                    <i class="fas fa-location-arrow me-2"></i> Nearest Service Providers
                    <span class="sacs-providers__coords">near {{ number_format((float) $lat, 4) }},
                        {{ number_format((float) $lng, 4) }}</span>
                </h2>
            @else
                <h2 class="sacs-providers__heading">
                    <i class="fas fa-store me-2"></i> All Service Providers
                </h2>
            @endif

            @if($providers->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-search fa-3x mb-3" style="color:#1a56db;opacity:.4;"></i>
                    <h5 class="text-muted">No providers found.</h5>
                    <p class="text-muted small">Click <strong>Find Nearest Provider</strong> above to allow location access.</p>
                </div>
            @else
                <div class="row g-4">
                    @foreach($providers->sortBy('distance') as $loop_index => $provider)
                        @php $isNearest = ($loop_index === $providers->sortBy('distance')->keys()->first() && $lat && $lng && isset($provider->distance) && $provider->distance !== null); @endphp
                        <div class="col-md-6 col-lg-4">
                            <div class="sacs-card hover-lift {{ $isNearest ? 'sacs-card--nearest' : '' }}">
                                @if($isNearest)
                                    <div class="sacs-card__nearest-badge">
                                        <i class="fas fa-trophy me-1"></i> Nearest to You
                                    </div>
                                @endif
                                <div class="sacs-card__header {{ $isNearest ? 'sacs-card__header--nearest' : '' }}">
                                    @if($provider->logo)
                                        <img src="{{ asset('storage/' . $provider->logo) }}" height="70"
                                            class="rounded-circle bg-white p-1 shadow-sm">
                                    @else
                                        <div class="sacs-card__icon-wrap {{ $isNearest ? 'sacs-card__icon-wrap--nearest' : '' }}">
                                            <i class="fas fa-store-alt fa-2x"
                                                style="color:{{ $isNearest ? '#059669' : '#1a56db' }};"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="sacs-card__body">
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        <h5 class="sacs-card__title">{{ $provider->business_name }}</h5>
                                        @if(isset($provider->distance) && $provider->distance !== null)
                                            <span class="sacs-card__distance {{ $isNearest ? 'sacs-card__distance--nearest' : '' }}">
                                                <i class="fas fa-location-arrow me-1"></i>{{ number_format($provider->distance, 1) }} km
                                            </span>
                                        @endif
                                    </div>
                                    {{-- Rating --}}
                                    <div class="mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= round($provider->avg_rating) ? 'text-warning' : 'text-muted' }}"
                                                style="font-size:.78rem;"></i>
                                        @endfor
                                        <small class="text-muted ms-1">{{ $provider->avg_rating }}/5
                                            ({{ $provider->rating_count }})</small>
                                    </div>
                                    <p class="sacs-card__meta"><i
                                            class="fas fa-map-marker-alt me-1 text-danger"></i>{{ $provider->address }}</p>
                                    @if($provider->phone)
                                        <p class="sacs-card__meta"><i class="fas fa-phone me-1"
                                                style="color:#1a56db;"></i>{{ $provider->phone }}</p>
                                    @endif
                                    @if($provider->description)
                                        <p class="sacs-card__desc">{{ Str::limit($provider->description, 80) }}</p>
                                    @endif
                                </div>
                                <div class="sacs-card__footer">
                                    <a href="{{ route('providers.show', $provider) }}"
                                        class="sacs-card__btn {{ $isNearest ? 'sacs-card__btn--nearest' : '' }}">
                                        <i class="fas fa-eye me-2"></i> View Services &amp; Book
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- Car Selection Modal --}}
    <div class="modal fade" id="carModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow-lg">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold"><i class="fas fa-car-side me-2" style="color:#1a56db;"></i>Select Your
                        Car</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted small">Prices are calculated based on your car model.</p>
                    <form action="{{ route('select-car') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Car Type</label>
                            <select id="carTypeSelect" class="form-select rounded-3">
                                <option value="">Choose type...</option>
                                @foreach($allCarTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Car Model</label>
                            <select name="car_model_id" id="carModelSelect" class="form-select rounded-3" required>
                                <option value="">Select type first...</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold">
                            <i class="fas fa-check me-2"></i>Confirm Selection
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // â”€â”€ Car type â†’ model cascade â”€â”€
        document.getElementById('carTypeSelect').addEventListener('change', function () {
            const typeId = this.value;
            const modelSelect = document.getElementById('carModelSelect');
            modelSelect.innerHTML = '<option>Loading...</option>';
            if (!typeId) { modelSelect.innerHTML = '<option value="">Select type first...</option>'; return; }
            fetch('/api/car-models?car_type_id=' + typeId)
                .then(r => r.json())
                .then(models => {
                    modelSelect.innerHTML = '<option value="">Choose model...</option>';
                    models.forEach(m => modelSelect.innerHTML += `<option value="${m.id}">${m.name}</option>`);
                });
        });

        // â”€â”€ Find Nearest Provider â€” geolocation â”€â”€
        document.getElementById('findNearestBtn').addEventListener('click', function () {
            const btn = this;
            const status = document.getElementById('geoStatus');

            if (!navigator.geolocation) {
                status.textContent = 'âš  Geolocation is not supported by your browser.';
                status.style.color = '#dc3545';
                return;
            }

            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Detecting locationâ€¦';
            status.textContent = '';

            navigator.geolocation.getCurrentPosition(
                pos => {
                    // Redirect with lat/lng â€” providers list will refresh
                    window.location.href = '/?lat=' + pos.coords.latitude + '&lng=' + pos.coords.longitude;
                },
                err => {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-location-crosshairs me-2"></i> Find Nearest Provider';
                    status.textContent = 'âš  Location access denied. Please allow location in your browser settings.';
                    status.style.color = '#dc3545';
                },
                { enableHighAccuracy: true, timeout: 10000 }
            );
        });
    </script>

@endpush
// update: feat: add breadcrumb navigation component to layouts (2026-04-07)

// update: feat: add breadcrumb navigation component to layouts (2026-03-26)
