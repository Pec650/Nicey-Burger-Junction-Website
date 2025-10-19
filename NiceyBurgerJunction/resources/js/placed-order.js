const cancelOrderButton = document.getElementById("cancel");
if (cancelOrderButton) { cancelOrderButton.addEventListener('click', () => {
    showConfirm(cancelOrderButton.value, "Are you sure you want to <b>cancel this order?</b>");
});}