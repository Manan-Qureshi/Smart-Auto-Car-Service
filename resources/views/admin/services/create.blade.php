@extends('layouts.app')

@section('content')
    <div class="container fade-in-up">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="glass-card p-4 bg-white">
                    <h4 class="mb-4 text-primary fw-bold">Add New Service</h4>

                    <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label text-dark">Service Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-dark">Type</label>
                            <input type="text" name="type" class="form-control" value="standard" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-dark">Time Slot Category</label>
                            <select name="duration_minutes" class="form-select" required>
                                <option value="45">Short (45 min gap)</option>
                                <option value="90">Medium (1 hr 30 min gap)</option>
                                <option value="135">Large (2 hr 15 min gap)</option>
                                <option value="210">XL (3 hr 30 min gap)</option>
                                <option value="300">XXL (5 hr gap)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-dark">Base Price (PKR)</label>
                            <input type="number" step="0.01" name="base_price" class="form-control" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-dark">Description</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-dark">Service Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <small class="text-muted">Optional. Displays on the service card.</small>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.services.index') }}" class="btn btn-light text-muted">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4 rounded-pill">Create Service</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection