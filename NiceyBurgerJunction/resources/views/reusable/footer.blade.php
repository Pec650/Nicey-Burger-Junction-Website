@vite('resources/css/reusable/footer.css')
<footer>
    <div id="footerContainer">
        <div class="footerContainer">
            <div class="blockContainer" id="companyFooter">
                <img src="{{ asset('images/Icons/Logo.png') }}">
            </div>
            <div class="blockContainer" id="aboutSection">
                <h3>ABOUT</h3>
                <p>Welcome to the Nicey Burger Junction website.</p>
                <div class="socialMedias-icons">
                    <a href="https://www.facebook.com/profile.php?id=61552663228146"><img src="{{ asset('images/Icons/Facebook.png') }}"></a>
                    <a href="https://www.tiktok.com/@niceyburgerjunction"><img src="{{ asset('images/Icons/Tiktok.png') }}"></a>
                </div>
            </div>
            <div class="blockContainer" id="quickSites">
                <h3>QUICKSITES</h3><br>
                <nav>
                    <a href="{{ route('about') }}">ABOUT</a><br><br>
                    <a href="{{ route('menu') }}">MENU</a><br><br>
                    <a href="{{ route('career') }}">CAREER</a>
                </nav>
            </div>
        </div>
    </div>
    <center>
    <div id="copyrightSection">
        <hr>
        <p>Copyright © 2025 Nicey Burger Junction</p>
    </div>
    </center>
</footer>