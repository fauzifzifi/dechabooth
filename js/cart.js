const cart = {};
const cartCount = document.getElementById("cartCount");
const cartPanel = document.getElementById("cartPanel");
const cartItems = document.getElementById("cartItems");
const cartTotal = document.getElementById("cartTotal");
const cartButton = document.getElementById("cartButton");
const closeCart = document.getElementById("closeCart");

// fungsi menambah item ke keranjang
function addToCart(name, price, qty) {
  cart[name] = { price, qty };
  updateCart();
}

// fungsi update keranjang (isi + total)
function updateCart() {
  let totalQty = 0;
  let totalHarga = 0;
  cartItems.innerHTML = "";

  for (const [name, item] of Object.entries(cart)) {
    const subtotal = item.price * item.qty;
    totalHarga += subtotal;
    totalQty += item.qty;
    const div = document.createElement("div");
    div.className = "cart-item";
    div.innerHTML = `<span>${name} x${
      item.qty
    }</span><span>Rp${subtotal.toLocaleString()}</span>`;
    cartItems.appendChild(div);
  }

  cartCount.textContent = totalQty;
  cartTotal.textContent = totalHarga.toLocaleString();
}

// event buka & tutup panel
cartButton.addEventListener("click", () => {
  cartPanel.classList.toggle("active");
});

closeCart.addEventListener("click", () => {
  cartPanel.classList.remove("active");
});

// event tombol + dan -
document.querySelectorAll(".quantity-controls").forEach((box) => {
  const plus = box.querySelector(".plus");
  const minus = box.querySelector(".minus");
  const qtyText = box.querySelector(".quantity-number");
  const name = box.dataset.name;
  const price = parseInt(box.dataset.price);

  plus.addEventListener("click", () => {
    let qty = parseInt(qtyText.textContent) + 1;
    qtyText.textContent = qty;
    addToCart(name, price, qty);
  });

  minus.addEventListener("click", () => {
    let qty = parseInt(qtyText.textContent);
    if (qty > 0) {
      qty--;
      qtyText.textContent = qty;
      if (qty === 0) delete cart[name];
      else cart[name].qty = qty;
      updateCart();
    }
  });
});
