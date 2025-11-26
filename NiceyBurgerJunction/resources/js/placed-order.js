const cancelOrderButton = document.getElementById("cancel");
if (cancelOrderButton) { cancelOrderButton.addEventListener('click', () => {
    showConfirm(cancelOrderButton.value, "Are you sure you want to <b>cancel this order?</b>");
});}

const completeOrderButton = document.getElementById("complete");
if (completeOrderButton) { completeOrderButton.addEventListener('click', () => {
    showConfirm(completeOrderButton.value, "<b>Please confirm that your order is complete.</b>");
});}

document.addEventListener("DOMContentLoaded", () => {
    const cancelBtn = document.querySelector(".cancel-btn");  
    const cancelModal = document.querySelector("#cancelModal");
    const cancelClose = document.querySelector("#cancelClose");

    if (cancelBtn) {
        cancelBtn.addEventListener("click", (e) => {
            e.preventDefault();
            cancelModal.style.display = "flex";  
        });
    }

    if (cancelClose) {
        cancelClose.addEventListener("click", () => {
            cancelModal.style.display = "none"; 
        });
    }
});
