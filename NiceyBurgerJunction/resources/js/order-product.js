document.addEventListener('DOMContentLoaded', () => {

    const orderForm = document.getElementById("product-order-form");
    orderForm.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') event.preventDefault();
    });

    const orderQTY = document.getElementById("order-qty");
    document.getElementById("order-qty").addEventListener('change', () => {
        orderQTY.value = parseInt(orderQTY.value);
        if (orderQTY.value < 1) { orderQTY.value = 1 }
    });

    document.getElementById("subtract-qty").addEventListener('click', () => {updateQuantity('-')});
    document.getElementById("add-qty").addEventListener('click', () => {updateQuantity('+')});

    function updateQuantity(operator) {
        const productQty = document.getElementById("order-qty");
        if (operator == '-' && productQty.value > 1) {
            --productQty.value;
        } else if (operator == '+') {
            ++productQty.value;
        }

        const totalDisplay = document.getElementById("total-display");
        const productPrice = document.getElementById("product-price-value").value;
        totalDisplay.innerHTML = `Total: ₱ ${parseFloat(productQty.value * productPrice).toFixed(2)}`;
    }

    const wordCount = document.getElementById("character-counter");
    const orderRequestText = document.getElementById("order-request");
    console.log(orderRequestText.value.length);
    orderRequestText.addEventListener('input', () => {
        wordCount.innerHTML = `Limit: ${orderRequestText.value.length} / 255`;
    });

    var dropped = true;
    document.getElementById("req-dropdown").addEventListener("click", () => {
        const descDropdown = document.getElementById("req-dropdown");
        if (dropped) {
            dropped = false;
            descDropdown.style.rotate = "-90deg";
            orderRequestText.style.height = "0px";
            orderRequestText.style.overflow = "hidden";
            wordCount.style.opacity = "0";
            wordCount.style.marginBottom = "-30px";
        } else {
            dropped = true;
            descDropdown.style.rotate = "0deg";
            orderRequestText.style.height = "200px";
            orderRequestText.style.overflow = "visible";
            wordCount.style.opacity = "100";
            wordCount.style.marginBottom = "0";
        }
    });

    let timer;
    let showInstruction = false;
    $('#req-more-info-p').hide(0);

    document.getElementById("req-more-info").addEventListener("click", () => {
        if (timer) {
            clearInterval(timer);
        }
        showDescInstruction();
    })

    function showDescInstruction() {
        if (!showInstruction) {
            showInstruction = true;
            $('#req-more-info-p').show(0);
            timer = setInterval(showDescInstruction, 5000);
        } else {
            showInstruction = false;
            $('#req-more-info-p').fadeOut("fast", "swing");
        }
    }

});