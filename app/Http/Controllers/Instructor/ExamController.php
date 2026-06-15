<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    /**
     * Display a listing of exams created by the instructor.
     */
    public function index()
    {
        // TODO: Retrieve exams created by the authenticated instructor (instructor_id = Auth::id())
        // TODO: Pass the exams data to the instructor.exams.index view

        return view('instructor.exams.index');
    }

    /**
     * Show the form for creating a new exam.
     */
    public function create()
    {
        return view('instructor.exams.create');
    }

    /**
     * Store a newly created exam in storage.
     */
    public function store(Request $request)
    {
        // TODO: Validate request inputs (title, duration_s)
        // TODO: Create a new Exam record with details:
        //       - title: $request->title
        //       - duration_s: $request->duration_s
        //       - instructor_id: Auth::id()
        // TODO: Save to the database
        // TODO: Redirect to the instructor exams list with a success message

        return redirect()->route('instructor.exams.index');
    }
}
