@extends('layouts.home_layout')
@section('title', "Placed Order")
@section('style')
    @vite(['resources/css/menu/placed-order.css'])
@endsection
@section('content')
<div id="order-container">
    <center><h4 id="your-header">YOUR</h4></center>
    <center><h2 id="order-header">ORDER NUMBER</h2></center>
    <center><h1 id="order-number">{{ $payment['id'] }}</h1></center>

    <center><h2 id="branchH">{{ $branch['branch_name'] }}</h2></center>
    <center><h4 id="addH">{{ $branch['barangay'] }}, {{ $branch['city'] }}</h4></center>

    <center><button onclick="window.location.href = '{{ route('order.map') }}'" id="veiwMap">VIEW MAP</button></center>

    <center><h3 id="phoneH"><strong>PHONE NUMBER</strong></h3></center>
    <center><h4 id="phone-number">{{ $branch['phone_num'] }}</h4></center>

    <center><h3 id="order-summary-header">ORDERS:</h3></center>
    <center><button onclick="window.location.href = '{{ route('order.list') }}'" id="summaryOrders">CHECK ORDERS</button></center>

    <br>
    <br>

    <div id="PC-complete">
        <center class="place-order-buttons">
            <button id="cancel" value="{{ route('order.cancel') }}">CANCEL</button>
            <button id="complete">COMPLETE</button>
        </center>
    </div>
    <div id="MB-complete">
        <center class="place-order-buttons">
            <button id="complete">COMPLETE</button>
            <button id="cancel" value="{{ route('order.cancel') }}">CANCEL</button>
        </center>
    </div>
</div>
@endsection
@section('script')
    @vite(['resources/js/placed-order.js'])
@endsection