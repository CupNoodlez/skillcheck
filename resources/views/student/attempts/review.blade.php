@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <a href="{{ route('student.exams.index') }}" class="btn btn-outline-secondary btn-sm">&larr; Back to Dashboard</a>
            </div>
            <div>
                <span class="badge bg-{{ $attempt->status === 'graded' ? 'success' : 'info' }} fs-6">
                    Status: <strong>{{ ucfirst($attempt->status) }}</strong>
                </span>
            </div>
        </div>

        <!-- Attempt Details Card -->
        <div class="card mb-4 shadow-sm border-primary">
            <div class="card-header bg-primary text-white py-3">
                <h4 class="mb-0">Exam Review: {{ $exam->title }}</h4>
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <p class="mb-2"><strong>Instructor:</strong> {{ $exam->instructor->name ?? 'N/A' }}</p>
                        <p class="mb-2"><strong>Started At:</strong> {{ $attempt->start_time ? $attempt->start_time->format('Y-m-d H:i:s') : 'N/A' }}</p>
                        <p class="mb-0"><strong>Submitted At:</strong> {{ $attempt->end_time ? $attempt->end_time->format('Y-m-d H:i:s') : 'N/A' }}</p>
                    </div>
                    <div class="col-md-5 text-md-end mt-3 mt-md-0">
                        <div class="p-3 bg-light rounded border d-inline-block text-center min-w-150">
                            <span class="text-muted d-block small fw-bold text-uppercase">Your Score</span>
                            @if ($attempt->status === 'graded')
                                <span class="fs-2 fw-bold text-success">{{ number_format($attempt->total_score, 1) }}</span>
                                <span class="text-muted">/ {{ number_format($attempt->max_score, 1) }}</span>
                            @else
                                <span class="fs-4 fw-bold text-info">Pending Grading</span>
                                <span class="text-muted d-block small mt-1">Some questions need manual grading</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h3 class="h4 mb-3">Questions & Your Responses</h3>

        @foreach ($questions as $index => $question)
            @php
                $answer = $answers->get($question->question_id);
            @endphp
            <div class="card mb-4 shadow-sm border-{{ !$answer ? 'danger' : ($question->type === 'essay' && is_null($answer->marks_awarded) ? 'warning' : 'light') }}">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Question {{ $index + 1 }} <small class="text-muted">({{ str_replace('_', ' ', $question->type) }})</small></h5>
                    <div>
                        @if ($answer && !is_null($answer->marks_awarded))
                            <span class="badge bg-{{ $answer->marks_awarded > 0 ? 'success' : 'danger' }} text-white">
                                Marks: {{ number_format($answer->marks_awarded, 1) }} / {{ number_format($question->marks, 1) }}
                            </span>
                        @else
                            <span class="badge bg-warning text-dark">
                                Marks: — / {{ number_format($question->marks, 1) }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <!-- Question Text -->
                    <p class="fs-5">{!! nl2br(e($question->question_text)) !!}</p>
                    
                    @if ($question->image_url)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $question->image_url) }}" alt="Question Diagram" class="img-thumbnail" style="max-height: 200px;">
                        </div>
                    @endif

                    <hr>

                    <!-- Student response display -->
                    <div class="mb-3">
                        <strong class="d-block mb-2 text-secondary">Options / Responses:</strong>
                        
                        @if ($question->type === 'multiple_choice' || $question->type === 'true_false')
                            <div class="list-group">
                                @foreach ($question->options as $option)
                                    @php
                                        $isSelected = $answer && $answer->selected_option === $option->option_id;
                                        $isCorrect = $option->is_correct;
                                        
                                        $bgClass = '';
                                        $badge = '';
                                        
                                        if ($isSelected) {
                                            if ($isCorrect) {
                                                $bgClass = 'list-group-item-success';
                                                $badge = '<span class="badge bg-success ms-2"><i class="bi bi-check-circle-fill"></i> Your Answer & Correct</span>';
                                            } else {
                                                $bgClass = 'list-group-item-danger';
                                                $badge = '<span class="badge bg-danger ms-2"><i class="bi bi-x-circle-fill"></i> Your Answer</span>';
                                            }
                                        } elseif ($isCorrect) {
                                            $bgClass = 'list-group-item-success bg-opacity-50';
                                            $badge = '<span class="badge bg-success bg-opacity-75 ms-2">Correct Answer</span>';
                                        }
                                    @endphp
                                    <div class="list-group-item d-flex justify-content-between align-items-center {{ $bgClass }}">
                                        <div>
                                            {{ $option->option_text }}
                                        </div>
                                        <div>
                                            {!! $badge !!}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                        @elseif ($question->type === 'question_answer')
                            <div class="p-3 bg-light rounded border mb-2">
                                <strong>Your Answer:</strong> 
                                @if ($answer && $answer->text_answer)
                                    <span class="font-monospace text-primary ms-1">{{ $answer->text_answer }}</span>
                                @else
                                    <span class="text-danger italic ms-1">No answer provided.</span>
                                @endif
                            </div>
                            <div class="mt-2 text-muted small">
                                <strong>Acceptable Correct Answers:</strong>
                                <ul class="mb-0 ps-3 mt-1">
                                    @foreach ($question->options->where('is_correct', true) as $opt)
                                        <li><span class="font-monospace">{{ $opt->option_text }}</span></li>
                                    @endforeach
                                </ul>
                            </div>

                        @elseif ($question->type === 'essay')
                            <div class="p-3 bg-light rounded border">
                                <strong>Your Answer:</strong>
                                <p class="mt-2 mb-0">{!! nl2br(e($answer->text_answer ?? 'No answer provided.')) !!}</p>
                            </div>
                            @if ($answer && is_null($answer->marks_awarded))
                                <div class="alert alert-warning mt-3 mb-0 py-2 small">
                                    <i class="bi bi-hourglass-split"></i> This essay response is currently awaiting grading by your instructor.
                                </div>
                            @endif
                        @endif

                        @if (!$answer)
                            <div class="alert alert-danger mt-2 py-2 small">
                                <i class="bi bi-exclamation-triangle-fill"></i> No answer was submitted for this question.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

        <div class="text-center mt-4 mb-5">
            <a href="{{ route('student.exams.index') }}" class="btn btn-primary px-4">Back to Dashboard</a>
        </div>
    </div>
</div>
@endsection
