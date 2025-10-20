@extends('layouts.auth_layout')
@section('title', "Forgot Password")
@section('style')
    @vite('resources/css/auth/forgot-pass-email.css')
@endsection
@section('content')
<div class="log-in-container">
    <div class="log-in-box">
        <h1>FORGOT PASSWORD</h1>
        <div class="form-container">
            <form method="POST" action="{{ route('forgot-password.email.check') }}">
                @csrf

                <input name="email" class="text-input" type="text" placeholder="Enter email address" value="{{ old('email') }}">
                
                <input type="submit" name="log-in-submit" value="CONTINUE">

                @if ($errors->any())
                    <p class="incorrect-error-paragraph">{{ $errors->first() }}</p>
                @endif
            </form>
        </div>
        <hr>
        <p class="more-paragraph" style="text-align: right"><a href="{{ route('login.show') }}">Return to Login</a></p>
    </div>
</div>
@endsection