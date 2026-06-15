<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        // TODO: Gather platform statistics (total users, exams, submissions, active sessions)
        // TODO: Pass data to the admin.dashboard view

        return view('admin.dashboard');
    }
}
