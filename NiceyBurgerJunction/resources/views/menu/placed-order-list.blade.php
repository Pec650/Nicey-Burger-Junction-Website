@extends('layouts.home_layout')
@section('title', "Placed Order")
@section('style')
    @vite(['resources/css/menu/placed-order-list.css'])
@endsection
@section('content')
<div id="order-container">
    <div id="back-container">
        <a href="{{ route('order.ongoing') }}"><img id="back-button" src="{{ asset('images/Icons/BackIcon.png') }}"></a>
    </div>
    <center><h1 id="order-list-header">YOUR ORDER</h1></center>
    <div id="item-container">
        @foreach ($orders as $order)
            <!-- Order Items -->
            <div class="order-item">
                @if ($order['product_image'] != null and file_exists("images/Menu/".$order['product_image']))
                    <img class="order-product-img" src="{{ asset("images/Menu/".$order['product_image']) }}" alt="{{ $order['product_name'] }}">
                @else
                    <img class="order-product-img" src="{{ asset('images/Icons/TemporaryImage.png') }}" alt="{{ $order['product_name'] }}">
                @endif
                <div class="details">
                    <h2>{{ $order['product_name'] }}</h2>
                    <span>
                        <h3>Qty: {{ $order['quantity'] }}</h3>
                        <p>₱ {{ number_format((float) $order['total_price'], 2) }}</p>
                    </span>
                </div>
                <div class="button-container">
                    <form action="{{ route('order.view', ['id' => $order['order_id']]) }}" method="POST">
                        @csrf
                        <button class="view-button">VIEW</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection