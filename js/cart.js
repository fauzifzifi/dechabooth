// === Inisialisasi keranjang dari localStorage ===
let cart = JSON.parse(localStorage.getItem("cart")) || {};

const cartCount = document.getElementById("cartCount");
const cartPanel = document.getElementById("cartPanel");
const cartItems = document.getElementById("cartItems");
const cartTotal = document.getElementById("cartTotal");
const cartButton = document.getElementById("cartButton");
const closeCart = document.getElementById("closeCart");
const checkoutBtn = document.getElementById("checkoutBtn");
const clearCartBtn = document.getElementById("clearCartBtn");

// === Simpan ke localStorage ===
function saveCart() {
  localStorage.setItem("cart", JSON.stringify(cart));
}

// === Fungsi menambah item ke keranjang ===
function addToCart(name, price, qty) {
  cart[name] = { price, qty };
  updateCart();
}

// === Fungsi update keranjang (isi + total) ===
function updateCart() {
  let totalQty = 0;
  let totalHarga = 0;

  if (cartItems) cartItems.innerHTML = "";

  for (const [name, item] of Object.entries(cart)) {
    const subtotal = item.price * item.qty;
    totalHarga += subtotal;
    totalQty += item.qty;

    if (cartItems) {
      const div = document.createElement("div");
      div.className = "cart-item";
      div.innerHTML = `
        <span>${name} x${item.qty}</span>
        <span>Rp${subtotal.toLocaleString()}</span>
      `;
      cartItems.appendChild(div);
    }
  }

  if (cartCount) cartCount.textContent = totalQty;
  if (cartTotal) cartTotal.textContent = totalHarga.toLocaleString();

  saveCart();
}

// === Event buka & tutup panel keranjang ===
if (cartButton && cartPanel) {
  cartButton.addEventListener("click", () => {
    cartPanel.classList.toggle("active");
  });
}

if (closeCart && cartPanel) {
  closeCart.addEventListener("click", () => {
    cartPanel.classList.remove("active");
  });
}

// === Event tombol + dan - pada setiap produk ===
document.querySelectorAll(".quantity-controls").forEach((box) => {
  const plus = box.querySelector(".plus");
  const minus = box.querySelector(".minus");
  const qtyText = box.querySelector(".quantity-number");
  const name = box.dataset.name;
  const price = parseInt(box.dataset.price);

  // Jika sudah ada di localStorage, tampilkan jumlah terakhir
  if (cart[name]) qtyText.textContent = cart[name].qty;

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

// tombol checkout WA
document.getElementById("checkoutBtn").addEventListener("click", () => {
  if (Object.keys(cart).length === 0) {
    alert("Keranjang masih kosong!");
    return;
  }

  let pesan = "Halo, saya ingin memesan:\n";
  let total = 0;

  for (const [name, item] of Object.entries(cart)) {
    pesan += `- ${name} x${item.qty} = Rp${(
      item.price * item.qty
    ).toLocaleString()}\n`;
    total += item.price * item.qty;
  }

  pesan += `\nTotal: Rp${total.toLocaleString()}`;
  pesan += `\n\nTerima kasih!`;

  const nomor = "6282336881878"; // ganti dengan nomor kamu
  const url = `https://wa.me/${nomor}?text=${encodeURIComponent(pesan)}`;

  window.open(url, "_blank");

  // kosongkan keranjang setelah pesan
  for (const key in cart) delete cart[key];
  updateCart();
  localStorage.removeItem("cart");
});

// === Tombol Hapus Semua Isi Keranjang ===
if (clearCartBtn) {
  clearCartBtn.addEventListener("click", () => {
    if (confirm("Yakin ingin menghapus semua isi keranjang?")) {
      cart = {};
      saveCart();
      updateCart();
      document
        .querySelectorAll(".quantity-number")
        .forEach((el) => (el.textContent = 0));
    }
  });
}

// === Jalankan saat halaman dimuat ===
updateCart();
