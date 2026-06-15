<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    /**
     * Update the grades (marks_awarded) for a specific answer (for essay/QA questions).
     */
    public function update(Request $request, $answerId)
    {
        // TODO: Validate request inputs (marks_awarded)
        // TODO: Find the Answer record (e.g. StudentAnswer::findOrFail($answerId))
        // TODO: Ensure the authenticated instructor has permission to grade this answer
        // TODO: Update the marks_awarded column with the graded marks
        // TODO: Save to the database
        // TODO: Return back to the grading view with a status message

        return redirect()->back();
    }
}
