<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    /**
     * Display list of exams available to the student.
     */
    public function index()
    {
        // TODO: Retrieve list of all active exams
        // TODO: Fetch existing student attempts for comparison
        // TODO: Pass data to the student.exams.index view

        return view('student.exams.index');
    }
}
