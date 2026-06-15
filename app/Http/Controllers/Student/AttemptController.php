<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttemptController extends Controller
{
    /**
     * Start a new exam attempt.
     */
    public function store(Request $request, $examId)
    {
        // TODO: Enforce composite unique constraint/rule for exam_id and student_id
        //       Check if the student (Auth::id()) already has an attempt for this exam ($examId).
        //       If an attempt already exists, reject the request (e.g., redirect back with errors or redirect to that attempt).
        
        // TODO: Insert a new record into the exam_attempts table with attributes:
        //       - exam_id: $examId
        //       - student_id: Auth::id()
        //       - started_at: now()
        //       - status: 'in_progress'
        
        // TODO: Redirect the student to the active attempt interface (take route)

        // For placeholder return, redirecting to the route to show the exam attempt
        return redirect()->route('student.exams.attempt.take', ['exam' => $examId, 'attempt' => 1]);
    }

    /**
     * Display the test-taking environment for a specific attempt.
     */
    public function show($examId, $attemptId)
    {
        // TODO: Find the attempt (Attempt::findOrFail($attemptId))
        // TODO: Validate that the attempt belongs to Auth::id() and matches $examId
        // TODO: Check if the attempt status is 'in_progress' and it hasn't timed out yet
        // TODO: Retrieve the exam questions and options
        // TODO: Pass all information to the student.attempts.take view

        return view('student.attempts.take');
    }

    /**
     * Submit the exam attempt for grading.
     */
    public function submit(Request $request, $examId, $attemptId)
    {
        // TODO: Find the attempt and lock it to prevent multiple submissions
        // TODO: Ensure the attempt status is 'in_progress' and belongs to the authenticated student
        
        // TODO: Iterate through all questions in this exam:
        //       For multiple choice questions:
        //       - Retrieve the student's answered option
        //       - Compare the selected option with the correct option in the database
        //       - Auto-populate marks_awarded (e.g., full marks if correct, 0 if incorrect)
        //       For essay or short answer questions:
        //       - Keep marks_awarded as null (to be graded manually by the instructor)

        // TODO: Calculate auto-graded total score
        // TODO: Update attempt attributes:
        //       - status: 'submitted'
        //       - submitted_at: now()
        // TODO: Redirect student back to the exams page with a success message

        return redirect()->route('student.exams.index');
    }
}
