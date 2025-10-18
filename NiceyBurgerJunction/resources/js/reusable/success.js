$("#successBox").fadeIn("fast", "swing");

setInterval(closeErrorPopUp, 5000);

document.getElementById("successful-close").addEventListener('click', () => {
    closeErrorPopUp();
})

function closeErrorPopUp() {
    $("#successBox").fadeOut("fast", "swing");
}