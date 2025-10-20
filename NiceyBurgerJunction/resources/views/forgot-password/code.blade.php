@extends('layouts.auth_layout')
@section('title', "Enter Code")
@section('style')
    @vite('resources/css/auth/forgot-pass-code.css')
@endsection
@section('content')
<div class="log-in-container">
    <div class="log-in-box">
        <h1>ENTER CODE</h1>
        <div class="form-container">
            <form id="code-form" method="POST" action="{{ route('forgot-password.code.check') }}">
                @csrf
                <input name="code" id="code-input" type="text" value="">
                <input type="submit" name="log-in-submit" value="CONTINUE">
                @if ($errors->any())
                    <p class="incorrect-error-paragraph">{{ $errors->first() }}</p>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
    @vite('resources/js/auth/code.js')
@endsection