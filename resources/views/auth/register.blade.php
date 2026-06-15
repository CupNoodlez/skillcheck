@extends('layouts.app')

@section('content')
    <h1>Register</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register') }}" method="POST">
        @csrf
        <div>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" value="{{ old('username') }}" required>
        </div>
        <br>
        <div>
            <label for="email">Email Address:</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required>
        </div>
        <br>
        <div>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
        </div>
        <br>
        <div>
            <label for="password_confirmation">Confirm Password:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>
        </div>
        <br>
        <div>
            <label for="role">Role:</label>
            <select name="role" id="role" required>
                <option value="student" {{ old('role') === 'student' ? 'selected' : '' }}>Student</option>
                <option value="instructor" {{ old('role') === 'instructor' ? 'selected' : '' }}>Instructor</option>
            </select>
        </div>
        <br>
        <button type="submit">Register</button>
    </form>

    <p>Already have an account? <a href="{{ route('login') }}">Login here</a></p>
@endsection
