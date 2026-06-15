@extends('layouts.app')

@section('content')
    <h1>Login</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf
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
        <button type="submit">Login</button>
    </form>

    <p>Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
@endsection
