@extends('layouts.home_layout')
@section('title', "Menu")
@section('style')
    @vite(['resources/css/home/address-select.css'])
    @if ($addresses->count() == 1)
    <style>
        #address-item-container {
            grid-template-columns: repeat(1, 1fr);
        }
    </style>
    @endif
@endsection
@section('content')
<div id="address-container">
    <h1>SELECT BRANCH</h1>
    <div id="address-item-container">
        @foreach ($addresses as $address)
            <form action="{{ route('menu.set_address', ['id' => $address['id']]) }}" method="POST">
                @csrf
                <button type="submit" class="address-button">
                    <div class="address-item">
                        <div class="address-image"></div>
                        <h2>{{ $address['street'] }}</h2>
                        <h4>{{ $address['barangay'] }}, {{ $address['city'] }}</h4>
                    </div>
                </button>
            </form>
        @endforeach
    </div>
</div>
@endsection