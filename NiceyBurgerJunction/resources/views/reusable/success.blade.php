@if (session('success_msg'))
@vite(['resources/css/reusable/success.css'])

<div id="successBox">
    <div id="success-box">
        <span>
            <p id="successful-text">{{ session('success_msg') }}</p>
            <div id="successful-close"></div>
        </span>
    </div>
</div>

@php
    session()->forget('success_msg');
@endphp

@vite(['resources/js/reusable/success.js'])
@endif