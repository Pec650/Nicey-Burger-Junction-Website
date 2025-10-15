@extends('layouts.auth_layout')
@section('title', "Sign Up")
@section('style')
    @vite('resources/css/auth/register.css')
@endsection
@section('content')
<div class="sign-up-container">
    <div class="sign-up-box">
        <h1>REGISTER</h1>
        <div class="form-container">
            <form method="POST" action="{{ route('register')  }}">
                @csrf

                <label for="username">Username</label><br>
                <input name="username" type="text" value="{{ old('username') }}">

                <label for="email">Email</label><br>
                <input name="email" type="text" value="{{ old('email') }}">

                <label for="password">Password</label><br>
                <input name="password" id="sign-up-password" type="password" autocomplete="off">
                <button type="button" id="show-password-button" class="show-password" onclick="showPassword('sign-up-password', 'hide-password')">
                    <div class="show-pass"><div id="hide-password" class="hide-pass"></div></div>
                </button>
                
                <label for="password_confirmation">Confirm Password</label><br>
                <input name="password_confirmation" id="sign-up-confirm-password" type="password" autocomplete="off">
                <button type="button" id="show-password-button" class="show-password" onclick="showPassword('sign-up-confirm-password', 'hide-confirm')">
                    <div class="show-pass"><div id="hide-confirm" class="hide-pass"></div></div>
                </button>

                <input type="submit" name="sign-up-submit" value="SIGN UP">
                
                @if ($errors->any())
                    <p class="incorrect-error-paragraph">{{ $errors->first() }}</p>
                @endif
            </form>
        </div>
        <hr>
        <p class="more-paragraph">Already have an account? <a href="{{ route('login.show') }}">LOGIN HERE</a></p>
    </div>
</div>
@endsection
@section('script')
<script>
    let showPass = false;

    function showPassword(input_id, icon_id) {
        showPass = !showPass;

        const input = document.getElementById(input_id);
        input.type = (showPass) ? "text" : "password";

        const hide_icon = document.getElementById(icon_id);
        hide_icon.style.visibility = (showPass) ? "hidden" : "visible";
    }
</script>
@endsection