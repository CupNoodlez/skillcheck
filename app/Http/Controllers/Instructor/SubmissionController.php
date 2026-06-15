<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    /**
     * Display a listing of student submissions for a specific exam.
     */
    public function index($examId)
    {
        // TODO: Find the exam or fail
        // TODO: Retrieve all attempts for the exam where status is 'submitted' or 'graded'
        // TODO: Pass the attempts to the instructor.submissions.index view

        return view('instructor.submissions.index');
    }

    /**
     * Show a specific submission for grading.
     */
    public function show($attemptId)
    {
        // TODO: Find the exam attempt with relationships (student, answers, questions, options)
        // TODO: Ensure the authenticated instructor owns the exam associated with this attempt
        // TODO: Pass the attempt details to the instructor.submissions.grade view

        return view('instructor.submissions.grade');
    }

    /**
     * Finalize the evaluation and mark the attempt as graded.
     */
    public function finalize(Request $request, $attemptId)
    {
        // TODO: Find the attempt
        // TODO: Ensure all essay/manual questions have been graded (marks_awarded is not null)
        // TODO: Calculate the final total score/grade for the attempt
        // TODO: Update the attempt status to 'graded'
        // TODO: Redirect to the submission listing with a success message

        return redirect()->route('instructor.exams.index');
    }
}
