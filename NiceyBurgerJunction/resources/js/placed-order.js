const cancelOrderButton = document.getElementById("cancel");
if (cancelOrderButton) { cancelOrderButton.addEventListener('click', () => {
    showConfirm(cancelOrderButton.value, "Are you sure you want to <b>cancel this order?</b>");
});}

const completeOrderButton = document.getElementById("complete");
if (completeOrderButton) { completeOrderButton.addEventListener('click', () => {
    showConfirm(completeOrderButton.value, "<b>Please confirm that your order is complete.</b>");
});}