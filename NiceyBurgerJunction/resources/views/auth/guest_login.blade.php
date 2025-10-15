@extends('layouts.auth_layout')
@section('title', "Guest Login")
@section('style')
    @vite('resources/css/auth/guest-login.css')
@endsection
@section('content')
<div class="log-in-container">
    <div class="log-in-box">
        <h1>YOUR NAME PLEASE</h1>
        <div class="form-container">
            <form action="{{ route('guest.login') }}" method="POST">
                @csrf
                <input name="name" id="guest-name" type="text" value="">
                @if ($errors->any())
                    <p class="incorrect-error-paragraph">{{ $errors->first() }}</p>
                @endif
                <input type="submit" id="guest-submit" value="ENTER">
                <p class="more-paragraph">Already have an account? <a href="{{ route('login.show') }}">LOG IN HERE</a></p>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    const guestName = document.getElementById("guest-name");
    const enterButton = document.getElementById("guest-submit");
    guestName.addEventListener("input", () => {
        if (guestName.value == "") {
            enterButton.classList.remove('active-button');
        } else {
            enterButton.classList.add('active-button');
        }
    })
</script>
@endsection