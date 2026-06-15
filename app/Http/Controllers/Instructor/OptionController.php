<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    /**
     * Show the form for creating a new option for a question.
     */
    public function create($examId, $questionId)
    {
        // TODO: Find the exam and question or fail
        // TODO: Pass the question/exam information to the instructor.options.create view

        return view('instructor.options.create');
    }

    /**
     * Store a newly created option in storage.
     */
    public function store(Request $request, $examId, $questionId)
    {
        // TODO: Validate request inputs (option_text, is_correct)
        // TODO: Verify that the question exists and belongs to the given exam
        // TODO: If this option is marked as correct (is_correct = true) and the question type is single choice,
        //       unmark other options for this question.
        // TODO: Create the Option record and save to database
        // TODO: Redirect back or to the questions management page

        return redirect()->route('instructor.exams.index');
    }
}
