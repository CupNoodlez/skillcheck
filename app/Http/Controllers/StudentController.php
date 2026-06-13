<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController
{
    
    public function dashboard () {
        return "this is the student dashboard";
    }

    public function examList () {
        return "this is where students get to see the lists of available exams and their due dates";
    }

    public function scoreHistory () {
        return "this is where students get to see their past scores from past exams";
    }

}