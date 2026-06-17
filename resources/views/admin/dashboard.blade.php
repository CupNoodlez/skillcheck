@extends('layouts.app')

@section('content')
    <h1>Admin Dashboard</h1>
    <p>Logged in as: {{ auth()->user()->username ?? 'Guest' }} ({{ auth()->user()->email ?? '' }}) | <a href="{{ route('profile.edit') }}">Edit Profile</a></p>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
@endsection
