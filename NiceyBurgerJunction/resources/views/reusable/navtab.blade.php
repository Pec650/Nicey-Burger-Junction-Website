@vite(['resources/css/reusable/navtab.css'])
<nav class="navbar">

    <!-- PC NAVIGATION -->
    <div id="pcNav" style="max-width: 1200px; margin-inline: auto;">
        <a href=""><img src="{{ asset('images/Icons/Logo.png') }}" alt="Nicey Burger Junction" class="Logo"></a>
        <div class="nav-options">
            <button id="home-nav" onclick="window.location.href = '{{ route('home') }}'">HOME</button>
            <button id="about-nav" onclick="window.location.href = '{{ route('about') }}'">ABOUT</button>
            <button id="menu-nav" onclick="window.location.href = '{{ route('menu') }}'">MENU</button>
            <button id="career-nav" onclick="window.location.href = '{{ route('career') }}'">CAREER</button>
        </div>

        <div class="user_nav_part">
            @if (Auth::check() && Auth::user()->user_type != 'Guest')
                @if ($order_count > 0)
                <button class="log-out-button" id="log-out-pc" value="{{ route('logout') }}" type="submit">LOG OUT</button>
                @else
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="log-out-button" type="submit">LOG OUT</button>
                </form>
                @endif
            @else
            <button class="log-in-button" onclick="window.location.href = '{{ route('login.show') }}'">LOG IN</button>
            @endif

            @auth
            <a href="{{ route('order.check') }}">
                <div id="review-order-button-click">
                    @if ($ongoing)
                        <div class="order-qty" style="margin-left: -25px;">ONGOING</div>
                    @else
                        <div class="order-qty">{{ $order_count }}</div>
                    @endif
                    <img src="{{ asset('images/Icons/ViewOrderIcon.png') }}" class="review-order">
                </div>
            </a>
            @endauth
        </div>
    </div>
    
    <!-- MOBILE NAVIGATION -->
    <div id="mbNav">
        <a href=""><img src="{{ asset('images/Icons/LogoIcon.png') }}" alt="Nicey Burger Junction" class="Logo"></a>
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
    
    @guest
        <a class="expanded-log-in-button" href="{{ route('login.show') }}">LOG IN</a>
    @endguest

    @auth
        <div id="expanded-review-order-button-click">
            <a href="{{ route('order.check') }}">
                @if ($ongoing)
                    <div class="expanded-order-qty" style="margin-left: -25px;">ONGOING</div>
                @else
                    <div class="expanded-order-qty">{{ $order_count }}</div>
                @endif
                <img src="{{ asset('images/Icons/ViewOrderIcon.png') }}" class="expanded-review-order">
            </a>
        </div><br><br><br><br>
        @if ($order_count > 0)
            <button type="submit" class="expanded-log-out-button" id="log-out-mb" value="{{ route('logout') }}" href="">LOG OUT</button>
        @else
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="expanded-log-out-button" href="">LOG OUT</button>
        </form>
        @endif
    @endauth
    
</div>
@vite(['resources/js/reusable/navtab.js'])
@if (Auth::check() && $order_count > 0) 
    <script>
        const logOutPC = document.getElementById("log-out-pc");
        if (logOutPC) { logOutPC.addEventListener('click', () => {
            showConfirm(logOutPC.value, "<b>Logging out will cancel your order</b>. Are you sure you want to do this action?");
        });}
        
        const logOutMB = document.getElementById("log-out-mb");
        if (logOutMB) { logOutMB.addEventListener('click', () => {
            showConfirm(logOutMB.value, "<b>Logging out will cancel your order</b>. Are you sure you want to do this action?");
        });}
    </script>
@endif