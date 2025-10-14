let isOpen = false;
const originalBodyStyle = document.body.style.cssText;

document.addEventListener("DOMContentLoaded", () => {
    $('#expandTab').hide(0);
    document.getElementById("expandTab").style.visibility = "visible";
});

const navScreenWidth = window.matchMedia("(max-width: 1400px)");
navScreenWidth.addEventListener("change", () => {
    if (!navScreenWidth.matches) {
        document.body.style.cssText = originalBodyStyle;

        isOpen = false;

        $('main').stop();
        $('footer').stop();
        $('#expandTab').stop();

        $('main').show(0);
        $('footer').show(0);
        $('#expandTab').hide(0);

        const more_icon = document.getElementById("more-icon");
        more_icon.style.backgroundImage = "url('../../../images/icons/MoreIcon.png')";
    }
});

const expandButton = document.getElementById('more-icon');
if (expandButton) { expandButton.addEventListener('click', () => {
    document.body.style.cssText = 'background-color: white; background-image: none';

    $('main').stop();
    $('footer').stop();
    $('#expandTab').stop();
    
    if (!isOpen) {
        $('main').show(0);
        $('footer').show(0);
        $('#expandTab').hide(0);

        $('main').fadeOut("fast", "swing");
        $('footer').fadeOut("fast", "swing");
        $('#expandTab').slideDown("slow", "swing");
        
        expandButton.style.backgroundImage = "url('../../../images/icons/CloseMoreIcon.png')";

        $('body').css({
            'background-color': "white",
            'background-image': "none",
        });

    } else {

        $('main').stop();
        $('footer').stop();
        $('#expandTab').stop();

        $('main').show(0);
        $('footer').show(0);
        $('#expandTab').hide(0);

        expandButton.style.backgroundImage = "url('../../../images/icons/MoreIcon.png')";
        
        document.body.style.cssText = originalBodyStyle;
    }

    isOpen = !isOpen;
});}