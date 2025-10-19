@extends('layouts.home_layout')
@section('title', ($order) ? $order['product_name'] : "View Product")
@section('style')
    @vite(['resources/css/menu/order-product.css'])
    <style>
        @media all and (max-width: 1000px) {
            p {
                font-size: 18px;
            }
        }
    </style>
@endsection
@section('content')
<div id="order-container">
    <div id="back-container">
        <a href="{{ route('order.list') }}"><img id="back-button" src="{{ asset('images/Icons/BackIcon.png') }}"></a>
    </div>
    <div id="product-info-container">
        <div id="img-container">
            @if ($order['product_image'] != null and file_exists("images/Menu/".$order['product_image']))
                <img id="product-img" src="{{ asset("images/Menu/".$order['product_image']) }}" alt="{{ $order['product_name'] }}">
            @else
                <img id="product-img" src="{{ asset('images/Icons/TemporaryImage.png') }}" alt="{{ $order['product_name'] }}">
            @endif
        </div>
        <div id="form-container">
            <h1 id="product-name">{{ $order['product_name']  }}</h1>
            <h2 id="product-price">₱ {{ number_format((float) $order['product_price'], 2) }}</h2>
            <hr>
            <h3>Quantity: {{ $order['quantity'] }}</label><h3>
            @if($order['request'])
            <h3 style="margin-top: 50px;">Request:</h3>
            <span style="margin-top: 0px">
                <p style="font-size: 25px">•</p>
                <p style="font-size: 25px; word-break: break-all;">{{ $order['request'] }}</p>
            </span>
            <hr>
            @endif
            <h3 id="total-display">Total: ₱ {{ number_format((float) $order['total_price'], 2) }}</h3>
        </div>
    </div>
</div>
@endsection