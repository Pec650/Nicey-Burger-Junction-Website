@vite(['resources/css/reusable/navtab.css', 'resources/js/reusable/navtab.js'])

<nav class="navbar">

    <!-- PC NAVIGATION -->
    <div id="pcNav" style="max-width: 1200px; margin-inline: auto;">
        <a href="{{ route('home') }}"><img src="{{ asset('images/Icons/Logo.png') }}" alt="Nicey Burger Junction" class="Logo"></a>
        <div class="nav-options">
            <button id="home-nav" onclick="window.location.href = '{{ route('home') }}'">HOME</button>
            <button id="about-nav" onclick="window.location.href = '{{ route('about') }}'">ABOUT</button>
            <button id="menu-nav" onclick="window.location.href = '{{ route('menu') }}'">MENU</button>
            <button id="career-nav" onclick="window.location.href = '{{ route('career') }}'">CAREER</button>
        </div>

        <div class="user_nav_part">
            @guest
            <button class="log-in-button" onclick="window.location.href = '{{ route('login.show') }}'">LOG IN</button>
            @endguest

            @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="log-out-button" type="submit">LOG OUT</button>
            </form>

            <div id="review-order-button-click">
                {{-- if placed order: --}}
                    {{-- <div class="order-qty" style="padding-inline: 15px; right: 13px; font-weight: 800;">ongoing</div> --}}
                {{-- else --}}
                    <div class="order-qty">0</div>
                {{-- endif --}}
                <img src="{{ asset('images/Icons/ViewOrderIcon.png') }}" class="review-order">
            </div>
            @endauth
        </div>
    </div>
    
    <!-- MOBILE NAVIGATION -->
    <div id="mbNav">
        <a href="{{ route('home') }}"><img src="{{ asset('images/Icons/LogoIcon.png') }}" alt="Nicey Burger Junction" class="Logo"></a>
        <button class="more-icon" id="more-icon"></button>
    </div>

</nav>

<div id="expandTab">
    <div class="navigationTab">
        <button onclick="window.location.href = '{{ route('home') }}'">HOME</button>
        <button onclick="window.location.href = '{{ route('about') }}'">ABOUT</button>
        <button onclick="window.location.href = '{{ route('menu') }}'">MENU</button>
        <button onclick="window.location.href = '{{ route('career') }}'">CAREER</button>
    </div>

    <div id="expanded-review-order-button-click">
        <a href="">
            <div class="expanded-order-qty">0</div>
            <img src="{{ asset('images/Icons/ViewOrderIcon.png') }}" class="expanded-review-order">
        </a>
    </div><br><br><br><br>

    @guest
        <a class="expanded-log-in-button" href="{{ route('login.show') }}">LOG IN</a>
    @endguest

    @auth
        <a class="expanded-log-out-button" href="{{ route('logout') }}">LOG OUT</a>
    @endauth
    
</div>
