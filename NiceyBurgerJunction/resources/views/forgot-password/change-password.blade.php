@extends('layouts.auth_layout')
@section('title', "Change Password")
@section('style')
    @vite('resources/css/auth/forgot-pass-change.css')
@endsection
@section('content')
<div class="sign-up-container">
    <div class="sign-up-box">
        <h1>CHANGE PASSWORD</h1>
        <div class="form-container">
            <form method="POST" action="{{ route('forgot-password.change')  }}">
                @csrf

                <label for="password">Password</label><br>
                <div class="password-container">
                    <input name="password" id="sign-up-password" type="password" autocomplete="off">
                    <button type="button" class="show-password" onclick="showPassword('sign-up-password', 'hide-password', 0)">
                        <div class="show-pass-container">
                            <div class="show-pass"><div id="hide-password" class="hide-pass"></div></div>
                        </div>
                    </button>
                </div>
                
                <label for="password_confirmation">Confirm Password</label><br>
                <div class="password-container">
                    <input name="password_confirmation" id="sign-up-confirm-password" type="password" autocomplete="off">
                    <button type="button" class="show-password" onclick="showPassword('sign-up-confirm-password', 'hide-confirm', 1)">
                        <div class="show-pass-container">
                            <div class="show-pass"><div id="hide-confirm" class="hide-pass"></div></div>
                        </div>
                    </button>
                </div>

                <input type="submit" name="sign-up-submit" value="UPDATE">
                
                @if ($errors->any())
                    <p class="incorrect-error-paragraph">{{ $errors->first() }}</p>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    let showPass = [false, false];

    function showPassword(input_id, icon_id, index) {
        showPass[index] = !showPass[index];

        const input = document.getElementById(input_id);
        input.type = (showPass[index]) ? "text" : "password";

        const hide_icon = document.getElementById(icon_id);
        hide_icon.style.visibility = (showPass[index]) ? "hidden" : "visible";
    }
</script>
@endsection