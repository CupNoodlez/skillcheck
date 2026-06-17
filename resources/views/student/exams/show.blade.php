@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="{{ route('student.exams.index') }}" class="btn btn-outline-secondary">&larr; Back to Dashboard</a>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
                </form>
            </div>

            <div class="card shadow">
                <div class="card-header bg-primary text-white py-3">
                    <h3 class="mb-0">{{ $exam->title }}</h3>
                </div>
                <div class="card-body p-4">
                    <h5 class="card-title text-secondary mb-1">Exam Details & Instructions</h5>
                    
                    <div class="d-flex align-items-center mt-2 mb-3">
                        @if($exam->instructor && $exam->instructor->profile_picture)
                            <img src="{{ asset('storage/' . $exam->instructor->profile_picture) }}" alt="Instructor Profile" class="rounded-circle me-2 shadow-sm" style="width: 32px; height: 32px; object-fit: cover; border: 1.5px solid #0d6efd;">
                        @else
                            <span class="rounded-circle bg-secondary text-white d-inline-flex align-items-center justify-content-center me-2 fw-bold shadow-sm" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                {{ strtoupper(substr($exam->instructor->username ?? 'I', 0, 1)) }}
                            </span>
                        @endif
                        <span class="text-muted small">Instructor: <strong>{{ $exam->instructor->username ?? 'Unknown' }}</strong></span>
                    </div>

                    <hr>

                    @if($exam->description)
                        <div class="mb-4">
                            <strong>Description:</strong>
                            <p class="text-muted mt-1">{{ $exam->description }}</p>
                        </div>
                    @endif

                    <div class="row mb-4">
                        <div class="col-sm-6">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span>Duration:</span>
                                    <span class="badge bg-secondary rounded-pill">
                                        {{ round($exam->duration_s / 60) }} minutes
                                    </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span>Total Questions:</span>
                                    <strong>{{ $exam->questions()->count() }}</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span>Question Ordering:</span>
                                    <span class="badge bg-{{ $exam->randomize_questions ? 'info text-white' : 'secondary text-white' }}">
                                        {{ $exam->randomize_questions ? 'Randomized' : 'Sequential' }}
                                    </span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-6">
                            <ul class="list-group list-group-flush">
                                @if($exam->start_time)
                                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                        <span>Available From:</span>
                                        <small>{{ \Carbon\Carbon::parse($exam->start_time)->format('Y-m-d H:i') }}</small>
                                    </li>
                                @endif
                                @if($exam->end_time)
                                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                        <span>Available Until:</span>
                                        <small class="text-danger">{{ \Carbon\Carbon::parse($exam->end_time)->format('Y-m-d H:i') }}</small>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>

                    <div class="alert alert-warning">
                        <h5>⚠️ Important Rules</h5>
                        <ul class="mb-0 small">
                            <li>Once you start, the timer cannot be paused.</li>
                            <li>Make sure you have a stable internet connection.</li>
                            <li>If the time expires, your answers will be automatically submitted.</li>
                            <li>Do not refresh or close the browser window unless necessary.</li>
                        </ul>
                    </div>

                    <!-- Verify availability constraints -->
                    @php
                        $now = now();
                        $isAvailable = true;
                        $errorMsg = '';

                        if ($exam->start_time && $now->lessThan(\Carbon\Carbon::parse($exam->start_time))) {
                            $isAvailable = false;
                            $errorMsg = 'This exam has not started yet.';
                        } elseif ($exam->end_time && $now->greaterThan(\Carbon\Carbon::parse($exam->end_time))) {
                            $isAvailable = false;
                            $errorMsg = 'This exam is no longer available (deadline passed).';
                        }
                    @endphp

                    @if($isAvailable)
                        <form action="{{ route('student.exams.attempt.store', ['exam' => $exam->exam_id]) }}" method="POST" class="d-grid mt-4">
                            @csrf
                            <button type="submit" class="btn btn-success btn-lg py-3">Start Attempt &rarr;</button>
                        </form>
                    @else
                        <div class="alert alert-danger mt-4 text-center">
                            <strong>Not Available:</strong> {{ $errorMsg }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
