<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of all users.
     */
    public function index()
    {
        // TODO: Retrieve all users (with roles)
        // TODO: Pass the users list to the admin.users.index view

        return view('admin.users.index');
    }

    /**
     * Show the form for editing the specified user's role.
     */
    public function edit($userId)
    {
        // TODO: Find user or fail (User::findOrFail($userId))
        // TODO: Pass user details to the admin.users.edit view

        return view('admin.users.edit');
    }

    /**
     * Update the user's role.
     */
    public function updateRole(Request $request, $userId)
    {
        // TODO: Validate role input (must be one of: student, instructor, admin)
        // TODO: Find the User record
        // TODO: Update user's role field to $request->role
        // TODO: Save to database
        // TODO: Redirect back or to users list with success message

        return redirect()->route('admin.users.index');
    }
}
