@vite(['resources/css/reusable/menusidebar.css'])

<div class="sidebar-PC">
    <h1>MENU</h1>
    <div class="menu-options">
        <button id="B1T1" onclick="changeMenuPC(this)">BUY 1 TAKE 1</button>
        <button id="Regular" onclick="changeMenuPC(this)">REGULAR</button>
        <button id="Drinks" onclick="changeMenuPC(this)">DRINKS</button>
        <button id="Others" onclick="changeMenuPC(this)">OTHERS</button>
    </div>
</div>

<div class="sidebar-Mobile">
    <button id="MenuButton">BUY 1 TAKE 1</button>
</div>

<div class="Sidebar-Options" id="Sidebar-Section">
    <button id="B1T1" onclick="changeMenu(this)">BUY 1 TAKE 1</button>
    <button id="Regular" onclick="changeMenu(this)">REGULAR</button>
    <button id="Drinks" onclick="changeMenu(this)">DRINKS</button>
    <button id="Others" onclick="changeMenu(this)">OTHERS</button>
</div>