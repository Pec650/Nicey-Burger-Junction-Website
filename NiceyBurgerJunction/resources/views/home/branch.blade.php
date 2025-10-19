@extends('layouts.home_layout')
@section('title', "Branch")
@section('style')
    @vite(['resources/css/home/branch.css'])
@endsection
@section('content')
<div id="branch-container">
    <h1>SELECT BRANCH</h1>
    <center>
        <form id="search-form" action="{{ route('menu.branch') }}" method="GET">
            <input type="text" id="search-bar"
            name="search"
            value="{{ request('search') }}" 
            placeholder="Search branch">
            <input type="submit" id="search-button" value="SEARCH">
        </form>
    </center>
    @if ($branches->count() > 0)
        <div id="branch-item-container">
            @foreach ($branches as $branch)
                    <form action="{{ route('menu.set_branch', ['id' => $branch['id']]) }}" method="POST">
                        @csrf
                        <button type="submit" class="branch-button">
                            <div class="branch-item">
                                <div class="branch-image"></div>
                                <h2>{{ $branch['branch_name'] }}</h2>
                                <h4>{{ $branch['barangay'] }}, {{ $branch['city'] }}</h4>
                            </div>
                        </button>
                    </form>
            @endforeach
        </div>
    @else
        <div id="branch-item-container" class="no-item-container">
            <div><center>
                <img src="{{ asset('images/Icons/EmptySearchResult.png') }}">
                <h4>Unable to find branch</h4>    
            </center></div>
        </div>
    @endif
</div>
@endsection