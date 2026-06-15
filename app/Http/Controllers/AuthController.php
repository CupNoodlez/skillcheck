<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Show registration form.
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle registration request.
     */
    public function register(Request $request)
    {
        // TODO: Validate request (name, email, password, etc.)
        // TODO: Create a new User model
        // TODO: Hash password using Hash::make($request->password)
        // TODO: Set default user role to 'student'
        // TODO: Save the user record in the database
        // TODO: Auto-login the user using Auth::login($user)
        // TODO: Redirect to the student dashboard

        return redirect()->route('student.exams.index');
    }

    /**
     * Show login form.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        // TODO: Validate credentials (email, password)
        // TODO: Attempt authentication using Auth::attempt($credentials)
        // TODO: Check the user's role to redirect to the proper dashboard:
        //       - 'admin' -> Redirect to admin.dashboard
        //       - 'instructor' -> Redirect to instructor.exams.index
        //       - 'student' -> Redirect to student.exams.index

        return redirect()->intended('/');
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request)
    {
        // TODO: Auth::logout()
        // TODO: Invalidate the session ($request->session()->invalidate())
        // TODO: Regenerate the CSRF token ($request->session()->regenerateToken())
        // TODO: Redirect to login page

        return redirect()->route('login');
    }
}
