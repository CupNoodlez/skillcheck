@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        @if(auth()->user()->role === 'instructor')
            <a href="{{ route('instructor.exams.index') }}" class="btn btn-outline-secondary btn-sm">&larr; Back to Dashboard</a>
        @elseif(auth()->user()->role === 'student')
            <a href="{{ route('student.exams.index') }}" class="btn btn-outline-secondary btn-sm">&larr; Back to Dashboard</a>
        @elseif(auth()->user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm">&larr; Back to Dashboard</a>
        @else
            <a href="/" class="btn btn-outline-secondary btn-sm">&larr; Back Home</a>
        @endif
    </div>

    <div class="row">
        <!-- Profile Sidebar Card -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 text-center p-4">
                <div class="card-body">
                    <div class="mb-3">
                        @if($user->profile_picture)
                            <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture" class="rounded-circle img-thumbnail shadow-sm" style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #0d6efd;">
                        @else
                            <div class="rounded-circle bg-secondary text-white d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 150px; height: 150px; font-size: 4rem; border: 3px solid #6c757d;">
                                {{ strtoupper(substr($user->username, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <h3 class="fw-bold text-dark mb-1">{{ $user->username }}</h3>
                    <p class="text-muted small mb-3">{{ $user->email }}</p>
                    <span class="badge bg-primary text-uppercase px-3 py-2" style="font-size: 0.8rem;">
                        {{ $user->role }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Edit Profile Form -->
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h4 class="card-title fw-bold mb-0 text-primary">Edit Profile Details</h4>
                </div>
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0 small">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Username Field -->
                        <div class="mb-3">
                            <label for="username" class="form-label fw-bold text-secondary small">Username</label>
                            <input type="text" name="username" id="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username', $user->username) }}" required>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email Field (Readonly) -->
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary small">Email Address</label>
                            <input type="text" class="form-control bg-light" value="{{ $user->email }}" readonly disabled>
                            <div class="form-text text-muted">Email address cannot be changed.</div>
                        </div>

                        <!-- Profile Picture Field -->
                        <div class="mb-3">
                            <label for="profile_picture" class="form-label fw-bold text-secondary small">Profile Picture</label>
                            <input type="file" name="profile_picture" id="profile_picture" class="form-control @error('profile_picture') is-invalid @enderror" accept="image/*">
                            <div class="form-text text-muted">Upload a new profile picture. Recommended: JPEG/PNG/WebP, max 2MB.</div>
                            @error('profile_picture')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">
                        <h5 class="text-secondary fw-bold mb-3">Change Password</h5>
                        <p class="text-muted small mb-3">Leave blank if you do not want to change your password.</p>

                        <div class="row">
                            <!-- Password Field -->
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label fw-bold text-secondary small">New Password</label>
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirm Password Field -->
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label fw-bold text-secondary small">Confirm New Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <button type="submit" class="btn btn-primary px-4 py-2 shadow-sm">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
