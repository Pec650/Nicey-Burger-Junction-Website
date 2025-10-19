@extends('layouts.home_layout')
@section('title', ($order) ? $order['product_name'] : "Edit Product")
@section('style')
    @vite(['resources/css/menu/order-edit.css'])
@endsection
@section('content')
<div id="order-container">
    <div id="back-container">
        <a href="{{ route('order.check') }}"><img id="back-button" src="{{ asset('images/Icons/BackIcon.png') }}"></a>
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
            <form id="product-order-form" action="{{ route('order.update') }}" method="POST">
                @csrf
                <input type="hidden" name="order-id" value="{{ $order['order_id'] }}">
                <input type="hidden" id="product-price-value" name="product-price" value="{{ $order['product_price'] }}">
                <input type="hidden" name="product-type" value="{{ $order['product_type'] }}">

                <label for="quantity">Quantity:</label><br>
                <div class="quantity-container">
                    <button type="button" id="subtract-qty">-</button>
                    <input name="quantity" id="order-qty" type="number" value="{{ $order['quantity'] }}" min="1" step="1" autocomplete="on">
                    <button type="button" id="add-qty">+</button>
                </div>

                <div id="req-more-info-p">
                    For a customizable order, input your request here. Make sure it is related to the meal or drink ordered.
                    <div class="triangle-down"></div>
                </div>

                <label for="request" style="margin-top: 20px;">Order Request <i>(Optional)</i>:</label>
                <img id="req-more-info" src="{{ asset('images/Icons/moreInfoButton.png') }}">
                <img id="req-dropdown" src="{{ asset('images/Icons/moreArrorIcon.png') }}"><br>
                <textarea name="request" id="order-request" maxlength="255" autocomplete="on" placeholder="Enter your order request here">{{ $order['request'] }}</textarea><br>

                <p id="character-counter">Limit: {{ strlen($order['request']) }} / 255</p>

                <h3 id="total-display">Total: ₱ {{ number_format((float) $order['product_price'] * $order['quantity'], 2) }}</h3>
                <input type="submit" id="submit-order" value="UPDATE ORDER">
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
    @vite(['resources/js/order-product.js'])
@endsection