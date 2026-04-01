@extends('layouts.app')

@section('content')
<div class="container fade-in-up">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="glass-card p-4 bg-white">
                <h4 class="mb-4 text-primary fw-bold">Edit Worker</h4>
                
                <form action="{{ route('admin.workers.update', $worker) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label text-dark">Full Name</label>
                        <input type="text" name="name" value="{{ $worker->name }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-dark">Email Address</label>
                        <input type="email" name="email" value="{{ $worker->email }}" class="form-control" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                           <label class="form-label text-dark">Phone Number</label>
                           <input type="text" name="phone_number" value="{{ $worker->phone_number }}" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                           <label class="form-label text-dark">CNIC</label>
                           <input type="text" name="cnic" value="{{ $worker->cnic }}" class="form-control" required>
                        </div>
                   </div>

                   <div class="mb-3">
                       <label class="form-label text-dark">Address</label>
                       <input type="text" name="address" value="{{ $worker->address }}" class="form-control" required>
                   </div>

                   <div class="mb-3">
                       <label class="form-label text-dark">Experience (Years)</label>
                       <input type="number" name="experience_years" value="{{ $worker->experience_years }}" class="form-control" required min="0">
                   </div>

                    <div class="mb-4">
                        <label class="form-label text-dark">New Password (Optional)</label>
                        <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current">
                    </div>
                    
                    <div class="mb-4">
                         <label class="form-label text-dark">Confirm New Password</label>
                         <input type="password" name="password_confirmation" class="form-control">
                     </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.workers.index') }}" class="btn btn-light text-muted">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4 rounded-pill">Update Worker</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
