let shownAll = false;
const showAllOrders = document.getElementById("show-all-button");
if (showAllOrders) { showAllOrders.addEventListener('click', () => {
    const itemContainer = document.getElementById("item-container");
    shownAll = !shownAll;
    showAllOrders.innerHTML = (shownAll) ? "HIDE ALL" : "SHOW ALL";
    itemContainer.style.maxHeight = (shownAll) ? "100%" : "400px";
});}

const itemDelete = document.querySelectorAll(".delete-order-item");
itemDelete.forEach(button => {
    button.addEventListener('click', () => {
        showConfirm(button.value, "Are you sure you want to <b>remove this item?</b>");
    });
});

const orderDelete = document.getElementById("delete-order");
if (orderDelete) {
    orderDelete.addEventListener('click', () => {
        showConfirm(orderDelete.value, "Are you sure you want to <b>cancel your order?</b>");
    });
}