@extends('layouts.app')

@section('content')
    <h1>student.exams.index</h1>
    <p>Logged in as: {{ auth()->user()->username ?? 'Guest' }} ({{ auth()->user()->email ?? '' }})</p>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
@endsection
