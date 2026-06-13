<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController
{
    public function dashboard () {
        return "this is the admin dashboard";
    }

    public function createExam () {
        return "this is where admins create and edit their exams";
    }

    public function questionBank () {
        return "this is where admins get to see the previous questions (separated by subject)";
    }

}
