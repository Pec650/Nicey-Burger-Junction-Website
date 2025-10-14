@extends('layouts.home_layout')
@section('title', "Career")
@section('style')
    @vite('resources/css/home/career.css')
@endsection
@section('content')
<div class="career-hero-container">
    <div class="career-hero">
        <h1>WORK WITH US</h1>
        <p>Be part of the Nicey Burger Junction family!</p>
        <button onclick="gotoHiring()">APPLY NOW!</button>
        <div class="hero-image"></div>
    </div>
</div>
<div class="career-content">
    <hr>

    <h1>WHY JOIN US?</h1>
    <div class="join-paragraph">
    <p>Here in Nicey Burger Junction, we strive to empower you with the tools and training you need to succeed. We offer a place where you can grow, belong, and be proud of the work you do.</p>
    </div>

    <hr>

    <h1>WE ARE HIRING</h1>

    <span class="career-options">

        <button>Cashier</button>
        <button>Manager</button>
        <button>Deliver Driver</button>

    </span>
</div>
@endsection
@section('script')
<script>

    function gotoHiring() {
        window.scrollTo({
            top: 700,
            behavior: "smooth", 
        });
    }

</script>
@endsection