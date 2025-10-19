document.getElementById("confirmation-close").addEventListener('click', () => {
    closeErrorPopUp();
});

document.getElementById("error-ok-button").addEventListener('click', () => {
    closeErrorPopUp();
});

function closeErrorPopUp() {
    document.getElementById("errorBox").style.display = "none";
}

document.getElementById("errorBox").style.display = "block";