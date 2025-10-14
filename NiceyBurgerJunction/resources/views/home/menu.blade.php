@extends('layouts.home_layout')
@section('title', "Menu")
@section('style')
    @vite('resources/css/home/menu.css')
@endsection
@section('content')
@include('reusable.menusidebar')
<div class="container_menu">
    <!-- Sidebar -->

    {{-- <?php if(isset($_SESSION['user_type']) and $_SESSION['user_type'] == 'Admin'): ?>
        <img src="../images/Icons/AddNewIcon.png" id="addNewButton">
    <?php endif; ?> --}}

    <!-- Main Content -->
    <div class="main-content">
        <div id="itemContainer"></div>
    </div>
</div>
@endsection