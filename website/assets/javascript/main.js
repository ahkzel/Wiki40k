function toggleCart() {
    var cart = document.getElementById("cart");
    cart.style.display = (cart.style.display === "none" || cart.style.display === "") ? "block" : "none";
}

function updateQuantity(action, setId, maxStock = null) {
    var quantityElement = document.getElementById("number-item-" + setId);
    var inputElement = document.getElementById("input-quantity-" + setId);
    var quantity = parseInt(quantityElement.innerText);

    if (action === "plus" && quantity < maxStock) {
        quantity++;
    } else if (action === "minus" && quantity > 0) {
        quantity--;
    }

    quantityElement.innerText = quantity;
    inputElement.value = quantity;
}