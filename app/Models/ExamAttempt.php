<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExamAttempt extends Model
{
    use HasUuids, HasFactory;

    protected $table = 'Exam_Attempts';
    protected $primaryKey = 'attempt_id';
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'exam_id',
        'student_id',
        'start_time',
        'end_time',
        'status',
        'question_order',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'question_order' => 'array',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id', 'exam_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id', 'user_id');
    }

    public function answers()
    {
        return $this->hasMany(StudentAnswer::class, 'attempt_id', 'attempt_id');
    }

    public function getTotalScoreAttribute()
    {
        return $this->answers()->sum('marks_awarded');
    }

    public function getMaxScoreAttribute()
    {
        return $this->exam ? $this->exam->questions()->sum('marks') : 0;
    }

    public function getStartedAtAttribute()
    {
        return $this->start_time;
    }

    public function getSubmittedAtAttribute()
    {
        return $this->end_time;
    }

    /**
     * Finalize and grade the attempt.
     */
    public function submit()
    {
        if ($this->status !== 'in_progress') {
            return;
        }

        $this->load(['exam.questions.options', 'answers']);
        $answers = $this->answers->keyBy('question_id');

        foreach ($this->exam->questions as $question) {
            $answer = $answers->get($question->question_id);
            if (!$answer) {
                $answer = new StudentAnswer([
                    'attempt_id' => $this->attempt_id,
                    'question_id' => $question->question_id,
                ]);
            }

            if ($question->type === 'multiple_choice' || $question->type === 'true_false') {
                $correctOption = $question->options->firstWhere('is_correct', true);
                if ($correctOption && $answer->selected_option === $correctOption->option_id) {
                    $answer->marks_awarded = $question->marks;
                } else {
                    $answer->marks_awarded = 0;
                }
            } elseif ($question->type === 'question_answer') {
                $correctAnswers = $question->options
                    ->where('is_correct', true)
                    ->pluck('option_text')
                    ->map(fn($val) => strtolower(trim($val)))
                    ->toArray();

                $studentText = strtolower(trim($answer->text_answer ?? ''));
                if (in_array($studentText, $correctAnswers) && $studentText !== '') {
                    $answer->marks_awarded = $question->marks;
                } else {
                    $answer->marks_awarded = 0;
                }
            } elseif ($question->type === 'essay') {
                // Keep marks_awarded as null for instructor manual grading.
            }

            $answer->save();
        }

        $this->status = 'submitted';
        $this->end_time = now();
        $this->save();

        // If the exam has no essay questions, it can be auto-finalized as 'graded'
        $hasEssay = $this->exam->questions->where('type', 'essay')->isNotEmpty();
        if (!$hasEssay) {
            $this->status = 'graded';
            $this->save();
        }
    }
}
