const menuScreenWidth = window.matchMedia("(max-width: 1200px)");
menuScreenWidth.addEventListener("change", () => {
    if (!menuScreenWidth.matches) {
        menuOpen = false;
        $(".Sidebar-Options").hide(0);
    }
});

let menuOpen = false;
const expandButton = document.getElementById("expand-sidebar");
if (expandButton) { expandButton.addEventListener('click', () => {
    if (!menuOpen) {
        $(".Sidebar-Options").slideDown("fast", "swing");
    } else {
        $(".Sidebar-Options").slideUp("fast", "swing");
    }
    menuOpen = !menuOpen;
});}