@extends('layouts.home_layout')
@section('title', "Placed Order")
@section('style')
    @vite(['resources/css/menu/placed-order-map.css'])
@endsection
@section('content')
<div id="order-container">
    <div id="back-container">
        <a href="{{ route('order.ongoing') }}"><img id="back-button" src="{{ asset('images/Icons/BackIcon.png') }}"></a>
    </div>
    <center><h2 id="branchH">{{ $branch['branch_name'] }}</h2></center>
    <center><h4 id="addH">{{ $branch['barangay'] }}, {{ $branch['city'] }}</h4></center>
    <div id="map-container">{!! $branch['map_html'] !!}</div>
</div>
@endsection