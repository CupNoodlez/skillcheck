<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        $validated = $request->validate([
            'username' => 'required|string|max:50|unique:Users,username',
            'email' => 'required|string|email|max:255|unique:Users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'sometimes|string|in:student,instructor',
            'profile_picture' => 'nullable|image|max:2048',
        ]);

        $profilePicturePath = null;
        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password_hash' => Hash::make($validated['password']),
            'role' => $validated['role'] ?? 'student',
            'profile_picture' => $profilePicturePath,
        ]);

        Auth::login($user);

        // Redirect based on role
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'instructor') {
            return redirect()->route('instructor.exams.index');
        } else {
            return redirect()->route('student.exams.index');
        }
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
        $credentials = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $login = $credentials['login'];
        $password = $credentials['password'];

        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt([$fieldType => $login, 'password' => $password])) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Redirect to role-specific dashboard
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'instructor') {
                return redirect()->route('instructor.exams.index');
            } else {
                return redirect()->route('student.exams.index');
            }
        }

        return back()->withErrors([
            'login' => 'The provided credentials do not match our records.',
        ])->onlyInput('login');
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
