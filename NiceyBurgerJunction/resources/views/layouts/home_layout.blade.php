<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BurgerJunction')</title>
    @vite(['resources/css/app.css', 'resources/css/bootstrap-5.3.3-dist/css/bootstrap.min.css'])
    @yield('style')
    @vite(['resources/js/JQUERY.js'])
</head>
<body>
    @include('reusable.navtab')
    <main>
        @yield('content')
    </main>
    @include('reusable.footer')
    @yield('script')
</body>
</html>