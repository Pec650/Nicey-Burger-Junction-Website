@if (session('error-title') && session('error'))
@vite(['resources/css/reusable/error.css'])

<div id="errorBox">
    <div class="darkednedBackground" id="error-dark-background">
        <div id="confirmation-box">
            <div id="confirmation-close"></div>
            <h1 id="error-title">{{ session('error-title') }}</h1><br>
            <p id="error-text">{{ session('error') }}</p>
            <center><button class="confirmation-buttons" id="error-ok-button">OK</button></center>
        </div>
    </div>
</div>

@php
    session()->forget('error-title');
    session()->forget('error');
@endphp

@vite(['resources/js/reusable/error.js'])
@endif