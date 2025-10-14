@extends('layouts.home_layout')
@section('title', "Home")
@section('style')
    @vite('resources/css/home/home.css')
@endsection
@section('content')
<div class="homeContainer">

    <div class="content" style="margin-bottom: 50px">
        <div class="empty-box"></div>
        <div class="text-box">
            <h1>NICEY</h1>
            <h2>BURGER JUNCTION</h2>
            <p>Hot burgers, pizzas, and hotdogs<br>Fresh, tasty and ready to serve!</p>
            <button onclick="window.location.href = '{{ route('menu') }}'">EXPLORE MENU</button>
        </div>
    </div>

    <!--aboutSection-->

    <div class="about-content">
        <div class="text-box about-section">
            <h2>LEARN MORE<br>ABOUT US</h2>
            <p>At Nicey Burger we will you the<br>best burger snacks that you<br>will undoubtedly enjoy!</p>
            <button onclick="window.location.href = '{{ route('about') }}'">LEARN MORE</button>
        </div>
    </div>

</div>

<div class="careerSection">
    <h1>BE PART OF OUR COMMUNITY</h1>
    <img src="{{ asset('images/Photos/Burger-Junction-Facebook-Image.jpg') }}">
    <p>Want to be part of our community?</p>
    <button onclick="window.location.href = '{{ route(name: 'career') }}'">JOIN US</button>
</div>
@endsection