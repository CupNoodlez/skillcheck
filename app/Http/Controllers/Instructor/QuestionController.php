<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Show the form for creating a new question for the exam.
     */
    public function create($examId)
    {
        // TODO: Find the exam or fail (Exam::findOrFail($examId))
        // TODO: Pass the exam to the instructor.questions.create view

        return view('instructor.questions.create');
    }

    /**
     * Store a newly created question in storage for the given exam.
     */
    public function store(Request $request, $examId)
    {
        // TODO: Validate request inputs (question_text, question_type, time_limit_s, image_url, etc.)
        // TODO: Find the associated exam (Exam::findOrFail($examId))
        // TODO: Create a new Question record belonging to the exam:
        //       - question_text: $request->question_text
        //       - question_type: $request->question_type (e.g. multiple_choice, essay)
        //       - time_limit_s: $request->time_limit_s (optional question level time limit)
        //       - image_url: $request->image_url (for question media support)
        // TODO: Save to the database
        // TODO: Redirect back or to the options creation page for this question

        return redirect()->route('instructor.exams.index');
    }
}
