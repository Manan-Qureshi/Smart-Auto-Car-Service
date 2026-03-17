@extends('layouts.app')
@section('content')
<div class="container-fluid px-4 py-3">
    <h3 class="fw-bold mb-4"><i class="fas fa-tools text-info me-2"></i>My Services</h3>
    
    <div class="glass-card p-4 rounded-4 shadow-sm mb-4">
        <h5 class="fw-bold mb-3"><i class="fas fa-clock text-info me-2"></i>Working Hours</h5>
        <form action="{{ route('provider.services.hours') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-5">
                    <label class="form-label fw-semibold">Start Time</label>
                    <input type="time" name="open_time" class="form-control rounded-3" value="{{ \Carbon\Carbon::parse($provider->open_time ?? '10:00:00')->format('H:i') }}" required>
                </div>
                <div class="col-md-5">
                    <label class="form-label fw-semibold">End Time</label>
                    <input type="time" name="close_time" class="form-control rounded-3" value="{{ \Carbon\Carbon::parse($provider->close_time ?? '16:00:00')->format('H:i') }}" required>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-info text-white w-100 rounded-pill"><i class="fas fa-save me-1"></i> Save Hours</button>
                </div>
            </div>
        </form>
    </div>

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <p class="text-muted mb-0">Enable the services you offer. Prices are set globally and apply equally to all providers.</p>
        @php $categories = $allServices->pluck('category')->filter()->unique()->sort(); @endphp
        @if($categories->count() > 0)
        <div style="min-width: 250px;">
            <select class="form-select rounded-pill" id="providerCategoryFilter">
                <option value="all">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ strtolower(trim($cat)) }}">{{ $cat }}</option>
                @endforeach
                <option value="uncategorized">Uncategorized</option>
            </select>
        </div>
        @endif
    </div>

    <div class="row g-3">
        @foreach($allServices as $service)
        @php $enabled = in_array($service->id, $enabledIds); @endphp
        <div class="col-md-6 col-lg-4 service-card-wrapper" data-category="{{ $service->category ? strtolower(trim($service->category)) : 'uncategorized' }}">
            <div class="glass-card p-3 rounded-4 d-flex align-items-center gap-3 {{ $enabled ? 'border border-success border-2' : '' }}">
                @if($service->image)
                    <img src="{{ asset('storage/'.$service->image) }}" class="rounded-3 flex-shrink-0 border" style="width: 55px; height: 55px; object-fit: cover;">
                @else
                    <div class="rounded-3 bg-primary d-flex align-items-center justify-content-center text-white flex-shrink-0" style="width: 55px; height: 55px;">
                        <i class="fas fa-concierge-bell"></i>
                    </div>
                @endif
                <div class="flex-grow-1">
                    <div class="fw-bold">{{ $service->name }}</div>
                    <div class="text-muted small">Base: PKR {{ number_format($service->base_price) }} · {{ $service->duration_minutes }}min</div>
                    @if($service->category)<div class="badge bg-light text-dark">{{ $service->category }}</div>@endif
                </div>
                <div class="d-flex flex-column align-items-end gap-2">
                    <span class="badge {{ $enabled ? 'bg-success' : 'bg-secondary' }}">
                        {{ $enabled ? 'Status: Active' : 'Status: Inactive' }}
                    </span>
                    <form action="{{ route('provider.services.toggle', $service) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm {{ $enabled ? 'btn-outline-danger' : 'btn-outline-success' }} rounded-pill">
                            {{ $enabled ? 'Disable Service' : 'Enable Service' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('providerCategoryFilter')?.addEventListener('change', function() {
    const selected = this.value;
    document.querySelectorAll('.service-card-wrapper').forEach(card => {
        card.style.display = (selected === 'all' || card.dataset.category === selected) ? '' : 'none';
    });
});
</script>
@endpush
