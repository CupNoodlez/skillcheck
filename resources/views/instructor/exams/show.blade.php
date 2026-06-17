@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="mb-4">
        <a href="{{ route('instructor.exams.index') }}" class="btn btn-outline-secondary btn-sm">&larr; Back to Exams List</a>
    </div>

    <!-- Exam Details Card -->
    <div class="card mb-4 shadow-sm border-primary">
        <div class="card-header bg-primary text-white">
            <h1 class="h3 mb-0">Exam: {{ $exam->title }}</h1>
        </div>
        <div class="card-body">
            <p class="lead">{{ $exam->description ?? 'No description' }}</p>
            <div class="row">
                <div class="col-md-4">
                    <strong>Duration:</strong> {{ $exam->duration_s }} seconds ({{ round($exam->duration_s / 60, 2) }} minutes)
                </div>
                <div class="col-md-4">
                    <strong>Start Time:</strong> {{ $exam->start_time ?? 'N/A' }}
                </div>
                <div class="col-md-4">
                    <strong>End Time:</strong> {{ $exam->end_time ?? 'N/A' }}
                </div>
            </div>
            
            <div class="row mt-2">
                <div class="col-md-12">
                    <span class="me-3">
                        <strong>Question Ordering:</strong> 
                        <span class="badge bg-{{ $exam->randomize_questions ? 'info text-white' : 'secondary text-white' }}">
                            {{ $exam->randomize_questions ? 'Randomized' : 'Sequential (Order Index)' }}
                        </span>
                    </span>
                    <span>
                        <strong>Viewable Responses:</strong> 
                        <span class="badge bg-{{ $exam->viewable_responses ? 'success text-white' : 'danger text-white' }}">
                            {{ $exam->viewable_responses ? 'Enabled' : 'Disabled' }}
                        </span>
                    </span>
                </div>
            </div>
            
            <div class="mt-3">
                <strong>Student Link:</strong>
                <div class="input-group">
                    <input type="text" readonly value="{{ route('student.exams.show', ['exam' => $exam->exam_id]) }}" class="form-control bg-light">
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <a href="{{ route('instructor.questions.create', ['exam' => $exam->exam_id]) }}" class="btn btn-success">+ Add Question</a>
                <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#importModal">
                    📥 Import Questions (JSON)
                </button>
                @if ($exam->questions->count() > 0)
                    <a href="{{ route('instructor.questions.export', ['exam' => $exam->exam_id]) }}" class="btn btn-outline-secondary">
                        📤 Export Questions (JSON)
                    </a>
                @endif
                @if ($exam->questions->count() > 1)
                    <a href="{{ route('instructor.questions.reorder', ['exam' => $exam->exam_id]) }}" class="btn btn-outline-primary">⇅ Reorder Questions</a>
                @endif
            </div>
        </div>
    </div>

    <!-- Questions Section -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h4 mb-0">Questions ({{ $exam->questions->count() }})</h2>
    </div>

    @if ($exam->questions->isEmpty())
        <div class="alert alert-info">
            No questions added to this exam yet.
        </div>
    @else
        <div class="row">
            @foreach ($exam->questions as $question)
                <div class="col-12 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center bg-light">
                            <div>
                                <span class="badge bg-primary text-white">Index: {{ $question->order_index }}</span>
                                <span class="badge bg-secondary text-white">Type: {{ str_replace('_', ' ', $question->type) }}</span>
                                <span class="badge bg-info text-dark">Marks: {{ $question->marks }}</span>
                                @if ($question->time_limit_s)
                                    <span class="badge bg-warning text-dark">Time Limit: {{ $question->time_limit_s }}s</span>
                                @endif
                                @if ($question->is_locked)
                                    <span class="badge bg-dark text-white">🔒 Locked Position</span>
                                @endif
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('instructor.questions.edit', ['exam' => $exam->exam_id, 'question' => $question->question_id]) }}" class="btn btn-outline-primary btn-sm">Edit Question</a>
                                <form action="{{ route('instructor.questions.destroy', ['exam' => $exam->exam_id, 'question' => $question->question_id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this question? This will reorder the remaining questions.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </div>
                        <div class="card-body">
                            @if ($question->image_url)
                                <div class="mb-3">
                                    <img src="{{ filter_var($question->image_url, FILTER_VALIDATE_URL) ? $question->image_url : asset('storage/' . $question->image_url) }}" alt="Question Image" class="img-thumbnail" style="max-width: 250px; max-height: 250px;">
                                </div>
                            @endif
                            
                            <p class="fs-5 fw-semibold mb-3">{{ $question->question_text }}</p>

                            @if (in_array($question->type, ['multiple_choice', 'true_false', 'question_answer']))
                                <div class="card p-3 bg-light">
                                    <h5 class="card-title h6 mb-3 text-muted">Options / Acceptable Answers:</h5>
                                    <ul class="list-group">
                                        @foreach ($question->options as $option)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <span class="badge bg-secondary text-white me-2">Index: {{ $option->order_index }}</span>
                                                    {{ $option->option_text }}
                                                </div>
                                                @if ($option->is_correct)
                                                    <span class="badge bg-success text-white">Correct Answer</span>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Import Questions Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('instructor.questions.import', ['exam' => $exam->exam_id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="importModalLabel">Import Questions from JSON</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="json_file" class="form-label fw-bold">Choose JSON File</label>
                            <input class="form-control" type="file" id="json_file" name="json_file" accept=".json" required>
                            <div class="form-text text-muted">Upload a valid JSON file containing an array of questions. Max size 2MB.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Import Mode</label>
                            <div class="d-flex gap-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="import_mode" id="mode_append" value="append" checked>
                                    <label class="form-check-label" for="mode_append">
                                        <strong>Append</strong> (Add to existing questions)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="import_mode" id="mode_overwrite" value="overwrite">
                                    <label class="form-check-label text-danger" for="mode_overwrite">
                                        <strong>Overwrite</strong> (Delete all current questions in this exam first)
                                    </label>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="alert alert-info">
                            <h6 class="alert-heading fw-bold mb-2">Supported JSON Schema Example:</h6>
                            <pre class="bg-dark text-light p-3 rounded mb-0" style="max-height: 250px; overflow-y: auto; font-size: 0.85rem;"><code>[
  {
    "question_text": "What is the capital of France?",
    "type": "multiple_choice",
    "marks": 5,
    "time_limit_s": 60,
    "is_locked": false,
    "image_url": "https://upload.wikimedia.org/wikipedia/commons/e/e6/Paris_Night.jpg",
    "options": [
      { "option_text": "Paris", "is_correct": true },
      { "option_text": "London", "is_correct": false }
    ]
  },
  {
    "question_text": "Laravel is built with PHP.",
    "type": "true_false",
    "correct_answer": true,
    "marks": 2
  },
  {
    "question_text": "What is the name of Laravel's ORM?",
    "type": "question_answer",
    "correct_answers": ["Eloquent", "eloquent"],
    "marks": 3
  },
  {
    "question_text": "Explain the Laravel request lifecycle.",
    "type": "essay",
    "marks": 10
  }
]</code></pre>
                        </div>

                        <div class="card bg-light border-0">
                            <div class="card-body">
                                <h6 class="card-title fw-bold">💡 Tip for Local Images:</h6>
                                <p class="card-text text-muted mb-0 small">
                                    You can include web image URLs in your JSON (using <code>"image_url": "https://..."</code>). For local files, import the questions first, and then click <strong>Edit Question</strong> to upload local images manually.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Upload & Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
