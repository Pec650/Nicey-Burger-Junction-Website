@extends('layouts.auth_layout')
@section('title', "Login")
@section('style')
    @vite('resources/css/auth/login.css')
@endsection
@section('content')
<div class="log-in-container">
    <div class="log-in-box">
        <h1>LOGIN</h1>
        <div class="form-container">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <label for="log-in-email">Email</label><br>
                <input name="email" type="text">

                <label for="log-in-password">Password</label><br>
                <input name="password" id="log-in-password" type="password" autocomplete="off">
                <button type="button" id="show-password-button" class="show-password" onclick="showPassword()">
                    <div class="show-pass"><div id="hide-icon" class="hide-pass"></div></div>
                </button>
                

                <input type="submit" name="log-in-submit" value="LOGIN">

                @if ($errors->any())
                    <p class="incorrect-error-paragraph" id="incorrect-error-paragraph">{{ $errors->first() }}</p>
                @endif
            </form>
        </div>
        <hr>
        <p class="more-paragraph">Need an account? <a href="{{ route('register.show') }}">SIGN UP HERE</a></p>
    </div>
</div>
@endsection
@section('script')
<script>
    let showPass = false;

    function showPassword() {
        showPass = !showPass;

        const input = document.getElementById("log-in-password");
        input.type = (showPass) ? "text" : "password";

        const hide_icon = document.getElementById("hide-icon");
        hide_icon.style.visibility = (showPass) ? "hidden" : "visible";
    }
</script>
@endsection