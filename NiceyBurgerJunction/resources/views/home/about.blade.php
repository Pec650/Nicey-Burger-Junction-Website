@extends('layouts.home_layout')
@section('title', "About")
@section('style')
    @vite('resources/css/home/about.css')
@endsection
@section('content')
<div class="about-header-bg">
    <h1>ABOUT US</h1>
    <h2>NICEY BURGER JUNCTION</h2>
</div>
<div class="main-content">
    <div class="content">
        <div>
            <img src="{{ asset('images/Photos/Burger-Junction-Facebook-Image.jpg') }}" height="600px" width= "600px">
            <p><em>One of the newly opened branches</em></p>
        </div>
        <div class="about-about">
            <p> 
                Nicey Burger Junction is a Local Food Stall chain and take-out stall with a variety of Burger meals
                and have options for Pizza meals as well. The origin of the business started in Cebu in the year of 2010,
                and as the business started to grow, more branches were made across Bohol, Leyte and Bantayan.
            </p><br>
            <p>
                The services we provide vary from a pick up order service, we also provide delivery services
                for meals that you want to order on our menu using our website.
            </p><br>
            <p>
                The proud staff of Nicey Burger Junction welcomes you with warmth and gratitude when you do visit any of
                our branches near you.
            </p>
        </div>
    </div>
</div>
@endsection