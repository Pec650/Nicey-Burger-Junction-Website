@extends('layouts.home_layout')
@section('title', ($product) ? $product['name'] : "Order Product")
@section('style')
    @vite(['resources/css/menu/order-product.css'])
@endsection
@section('content')
<div id="order-container">
    <div id="back-container">
        <a href="{{ route('menu.type', ['type' => Str::slug($product['type'])]) }}"><img id="back-button" src="{{ asset('images/Icons/BackIcon.png') }}"></a>
    </div>
    <div id="product-info-container">
        <div id="img-container">
            @if ($product['img_dir'] != null and file_exists("images/Menu/".$product['img_dir']))
                <img id="product-img" src="{{ asset("images/Menu/".$product['img_dir']) }}" alt="{{ $product['name'] }}">
            @else
                <img id="product-img" src="{{ asset('images/Icons/TemporaryImage.png') }}" alt="{{ $product['name'] }}">
            @endif
        </div>
        <div id="form-container">
            <h1 id="product-name">{{ $product['name']  }}</h1>
            <h2 id="product-price">₱ {{ number_format((float) $product['price'], 2) }}</h2>
            <hr>
            <form id="product-order-form" action="{{ route('order.create') }}" method="POST">
                @csrf
                <input type="hidden" name="product-id" value="{{ $product['id'] }}">
                <input type="hidden" id="product-price-value" name="product-price" value="{{ $product['price'] }}">
                <input type="hidden" name="product-type" value="{{ $product['type'] }}">

                <label for="quantity">Quantity:</label><br>
                <div class="quantity-container">
                    <button type="button" id="subtract-qty">-</button>
                    <input name="quantity" id="order-qty" type="number" value="1" min="1" step="1" autocomplete="on">
                    <button type="button" id="add-qty">+</button>
                </div>

                <div id="req-more-info-p">
                    For a customizable order, input your request here. Make sure it is related to the meal or drink ordered.
                    <div class="triangle-down"></div>
                </div>

                <label for="request" style="margin-top: 20px;">Order Request <i>(Optional)</i>:</label>
                <img id="req-more-info" src="{{ asset('images/Icons/moreInfoButton.png') }}">
                <img id="req-dropdown" src="{{ asset('images/Icons/moreArrorIcon.png') }}"><br>
                <textarea name="request" id="order-request" maxlength="255" autocomplete="on" placeholder="Enter your order request here" value=""></textarea><br>

                <p id="character-counter">Limit: 0 / 255</p>

                <h3 id="total-display">Total: ₱ {{ number_format((float) $product['price'], 2) }}</h3>
                <input type="submit" id="submit-order" value="ADD TO CART">
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
    @vite(['resources/js/order-product.js'])
@endsection