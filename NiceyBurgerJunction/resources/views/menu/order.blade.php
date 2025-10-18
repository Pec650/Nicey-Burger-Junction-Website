@extends('layouts.home_layout')
@section('title', "Orders")
@section('style')
    @vite(['resources/css/menu/order.css'])
@endsection
@section('content')
<div class="container">
    <div class="pickup-order">
        <h1>MY ORDER</h1>
        @if ($orders->count() >= 4)
        <button id="show-all-button">SHOW ALL</button>
        @endif
    </div>

    @if ($orders->count() > 0)
    <div id="item-container">
        @foreach ($orders->get() as $order)
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
                <div class="edit-order-container">
                    <form action="{{ route('order.edit', ['id' => $order['order_id']]) }}" method="POST">
                        @csrf
                        <button type="submit" id="editButton">EDIT</button>
                    </form>
                    <button class="delete-order-item" value="{{ route('order.delete', ['id' => $order['order_id']]) }}">
                        <img src="{{ asset('images/Icons/TrashCanIcon.png') }}" alt="Remove Item" id="cancel-order" class="active-cancel-order">
                    </button>
                </div>
            </div>
        @endforeach
    </div>
    @else
    <div id="item-container" class="no-item-container">
        <img src="{{ asset('images/Icons/EmptyOrderIcon.png') }}">
    </div>
    @endif

    @if ($address)
    <hr>
    <div id="address-container">
        <h1>{{ $address['street'] }}</h1>
        <h3>{{ $address['barangay'] }}, {{ $address['city'] }}</h3>
        <div id="map-container">{!! $address['map_html'] !!}</div>
    </div>
    <hr>
    @endif

    <!-- Total and Place Order Button -->
    <div class="total">
        <p id="total-display">Total: ₱ {{ number_format((float) $total_price, 2) }}</p>
    </div>
    <div class="order-button-container">
        @if ($orders->count() > 0)
            <button id="delete-order" value="{{ route('order.empty') }}">
                <img src="{{ asset('images/Icons/TrashCanIcon.png') }}" alt="Remove Order" title="Cancel Order" id="cancel-order" class="active-cancel-order">
            </button>
            <form action="" method="POST" id="order-review">
                @csrf
                <input type="submit" id="place-order" class="active-place-order" value="PLACE ORDER"></input>
            </form>
        @else
            <img src="{{ asset('images/Icons/TrashCanIcon.png') }}" alt="Remove Order" id="cancel-order">
            <button id="place-order">PLACE ORDER</button>
        @endif
    </div>
</div>
@endsection
@section('script')
    @vite(['resources/js/order.js']);
@endsection