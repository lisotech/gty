let cart = JSON.parse(localStorage.getItem('cart')) || [];

function updateCartCount() {
    const count = cart.reduce((sum, item) => sum + item.quantity, 0);
    const badge = document.getElementById('cart-count');
    if (badge) badge.innerText = count;
}

function addToCart(product) {
    const existing = cart.find(item => item.id === product.id);
    if (existing) {
        existing.quantity += 1;
    } else {
        cart.push({ ...product, quantity: 1 });
    }
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();
    alert(product.name + " added to cart!");
}

function renderCartPage() {
    const container = document.getElementById('cart-items');
    const summary = document.getElementById('cart-summary');
    if (!container) return;

    if (cart.length === 0) {
        container.innerHTML = "<p>Your cart is empty.</p>";
        if (summary) summary.style.display = 'none';
        return;
    }

    let html = `<table><tr><th>Product</th><th>Price</th><th>Quantity</th><th>Total</th><th>Action</th></tr>`;
    let total = 0;

    cart.forEach((item, index) => {
        let itemTotal = item.price * item.quantity;
        total += itemTotal;
        html += `<tr>
            <td>${item.name}</td>
            <td>ZMW ${Number(item.price).toFixed(2)}</td>
            <td><input type="number" min="1" value="${item.quantity}" onchange="updateQuantity(${index}, this.value)" style="width:50px;"></td>
            <td>ZMW ${itemTotal.toFixed(2)}</td>
            <td><button class="btn" style="background:red;padding:5px 10px;" onclick="removeFromCart(${index})">Remove</button></td>
        </tr>`;
    });

    html += `</table>`;
    container.innerHTML = html;
    if (summary) {
        summary.style.display = 'block';
        document.getElementById('cart-total').innerText = total.toFixed(2);
    }
}

function updateQuantity(index, qty) {
    cart[index].quantity = parseInt(qty);
    localStorage.setItem('cart', JSON.stringify(cart));
    renderCartPage();
    updateCartCount();
}

function removeFromCart(index) {
    cart.splice(index, 1);
    localStorage.setItem('cart', JSON.stringify(cart));
    renderCartPage();
    updateCartCount();
}

function handleCheckout() {
    const form = document.getElementById('checkout-form');
    if (!form) return;

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        if (cart.length === 0) {
            alert('Your cart is empty.');
            return;
        }

        const payload = {
            customer_name: document.getElementById('customer_name').value,
            phone_number: document.getElementById('phone_number').value,
            email: document.getElementById('email').value,
            payment_method: document.getElementById('payment_method').value,
            cart: cart
        };

        fetch('api/process_order.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                window.location.href = `payment.php?order_id=${data.order_id}`;
            } else {
                alert('Checkout failed: ' + data.message);
            }
        });
    });
}

document.addEventListener('DOMContentLoaded', updateCartCount);
