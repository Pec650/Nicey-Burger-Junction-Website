@extends('layouts.home_layout')
@section('title', "Orders")
@section('style')
    @vite(['resources/css/menu/order.css'])
@endsection
@section('content')
<div class="container">
    <form name="order-review" action="../database/create_payment.php" method="POST" id="order-review">

        <div class="pickup-order">
            <h1>PICK UP ORDER</h1>
        </div>

        <div id="item-container">
        </div>

        <!-- Total and Place Order Button -->
        <div class="total">
            <span>TOTAL: ₱ 0.00</span>
            <p style="font-weight: 800">STORE ADDRESS:</p>
            <p style="font-weight: 500; font-size: 25px; margin-top: 25px">GOV. M. CUENCO AVE</p>
            <p style="font-weight: 500">TALAMBAN, CEBU CITY</p>
        </div>
        <div class="order-button-container">
            <img src="../images/Icons/TrashCanIcon.png" alt="removeOrder" title="Cancel Order" id="cancel-order">
            <input type="submit" name="place-order" id="place-order" value="PLACE ORDER"></input>
        </div>
    </form>
</div>
@endsection