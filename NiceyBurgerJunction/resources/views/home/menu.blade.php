@extends('layouts.home_layout')
@section('title', "Menu")
@section('style')
    @vite(['resources/css/reusable/menusidebar.css', 'resources/css/home/menu.css'])
@endsection
@section('content')
<div id="branch-header">
    <h1>{{ $branch['branch_name'] }}</h1>
    <h3>{{ $branch['barangay'] }}, {{ $branch['city'] }}</h3>
    <center>
    @if ($order_count > 0) 
        <button id="change-branch" value="{{ route('menu.reset_branch') }}">CHANGE ADDRESS</button>
    @else
        <form action="{{ route('menu.reset_branch') }}" method="POST">
            @csrf
            <button id="change-branch">CHANGE ADDRESS</button>
        </form>
    @endif
    </center>
</div>
<div class="container-menu">

    <!-- Sidebar -->
    <div class="sidebar-PC">
        <h1>MENU</h1>
        <div class="menu-options">
            <button @if($type=='Buy 1 Take 1')class="selected"@endif onclick="window.location.href = '{{ route('menu.type', ['type' => 'buy-1-take-1']) }}'">BUY 1 TAKE 1</button>
            <button @if($type=='Regular')class="selected"@endif onclick="window.location.href = '{{ route('menu.type', ['type' => 'regular']) }}'">REGULAR</button>
            <button @if($type=='Drinks')class="selected"@endif onclick="window.location.href = '{{ route('menu.type', ['type' => 'drinks']) }}'">DRINKS</button>
            <button @if($type=='Others')class="selected"@endif onclick="window.location.href = '{{ route('menu.type', ['type' => 'others']) }}'">OTHERS</button>
        </div>
    </div>

    <div class="sidebar-Mobile">
        <button id="expand-sidebar">{{ $type }}</button>
    </div>

    <div class="Sidebar-Options" id="Sidebar-Section">
        @if($type!='Buy 1 Take 1')<button onclick="window.location.href = '{{ route('menu.type', ['type' => 'buy-1-take-1']) }}'">BUY 1 TAKE 1</button>@endif
        @if($type!='Regular')<button onclick="window.location.href = '{{ route('menu.type', ['type' => 'regular']) }}'">REGULAR</button>@endif
        @if($type!='Drinks')<button onclick="window.location.href = '{{ route('menu.type', ['type' => 'drinks']) }}'">DRINKS</button>@endif
        @if($type!='Others')<button onclick="window.location.href = '{{ route('menu.type', ['type' => 'others']) }}'">OTHERS</button>@endif
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div id="itemContainer">
            @if ($products)
            @foreach ($products as $p)
            <div class="item">
                @if ($p['img_dir'] != null and file_exists("images/Menu/".$p['img_dir']))
                    <img src="{{ asset("images/Menu/".$p['img_dir']) }}" alt="{{ $p['name'] }}">
                @else
                    <img src="{{ asset('images/Icons/TemporaryImage.png') }}" alt="{{ $p['name'] }}">
                @endif
                <div class="name">{{ Str::limit($p['name'], 20) }}</div>
                <div class="price">₱ {{ number_format((float) $p['price'], 2) }}</div>
                @guest
                    <button class="itemButton" onclick="window.location.href = '{{ route('guest.show') }}'">VIEW PRODUCT</button>
                @endguest
                @auth
                    <form action="{{ route('menu.product', ['id' => $p['id']]) }}" method="POST">
                        @csrf
                        <button class="itemButton">VIEW PRODUCT</button>
                    </form>
                @endauth
            </div>
            @endforeach
            @endif
        </div>
    </div>
</div>
@endsection
@section('script')
    @vite(['resources/js/menu.js'])
    @if ($order_count > 0) 
    <script>
        const changeBranchButton = document.getElementById("change-branch");
        changeBranchButton.addEventListener('click', () => {
            showConfirm(changeBranchButton.value, "Are you sure you want to change your branch? <b>This action will cancel your order.</b>");
        });
    </script>
    @endif
@endsection