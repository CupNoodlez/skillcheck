<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    /**
     * Save or update a student's answer for a specific question during an attempt.
     */
    public function store(Request $request, $examId, $attemptId)
    {
        // TODO: Validate request inputs (question_id, selected_option_id, text_answer)
        // TODO: Verify that the attempt is in_progress, matches $examId, and belongs to Auth::id()
        
        // TODO: Retrieve or instantiate a StudentAnswer record for this attempt_id and question_id:
        //       - If an answer already exists for this question, update it.
        //       - Otherwise, create a new record.
        // TODO: Handle answer types:
        //       - If multiple choice: store selected_option_id
        //       - If essay/QA: store text_answer
        // TODO: Save changes to the database
        // TODO: Return a JSON response or redirect back with status

        return redirect()->back();
    }
}
