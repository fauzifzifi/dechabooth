// === Inisialisasi keranjang dari localStorage ===
let cart = JSON.parse(localStorage.getItem("cart")) || {};

// Elemen DOM
let cartCount,
  cartPanel,
  cartItems,
  cartTotal,
  cartButton,
  closeCartBtn,
  checkoutBtn,
  clearCartBtn,
  cartOverlay,
  emptyCartMessage,
  buyerNameInput;

document.addEventListener("DOMContentLoaded", () => {
  cartCount = document.getElementById("cartCount");
  cartPanel = document.getElementById("cartPanel");
  cartItems = document.getElementById("cartItems");
  cartTotal = document.getElementById("cartTotal");
  cartButton = document.getElementById("cartButton");
  closeCartBtn = document.getElementById("closeCart");
  checkoutBtn = document.getElementById("checkoutBtn");
  clearCartBtn = document.getElementById("clearCartBtn");
  cartOverlay = document.getElementById("cartOverlay");
  emptyCartMessage = document.getElementById("emptyCartMessage");
  buyerNameInput = document.getElementById("buyerName");

  attachQuantityListeners();
  attachPanelListeners();
  attachCheckoutAndClearListeners();
  updateCart();
});

// === Simpan ke localStorage ===
function saveCart() {
  localStorage.setItem("cart", JSON.stringify(cart));
}

// === Tambah / Update Cart ===
function addToCart(id, name, price, qty) {
  if (qty === 0) delete cart[id];
  else cart[id] = { name, price, qty };
  updateCart();
}

// === Kosongkan Cart ===
function clearCartAndResetCounters() {
  cart = {};
  localStorage.removeItem("cart");

  document
    .querySelectorAll(".quantity-number")
    .forEach((el) => (el.textContent = "0"));

  updateCart();
}

// === Update UI Cart ===
function updateCart() {
  let totalQty = 0;
  let totalHarga = 0;
  if (!cartItems) return;

  cartItems.innerHTML = "";

  Object.entries(cart).forEach(([id, item]) => {
    const subtotal = item.price * item.qty;
    totalHarga += subtotal;
    totalQty += item.qty;

    const div = document.createElement("div");
    div.className = "cart-item";
    div.innerHTML = `
      <span>${item.name} x${item.qty}</span>
      <span>Rp${subtotal.toLocaleString("id-ID")}</span>
    `;
    cartItems.appendChild(div);
  });

  if (emptyCartMessage) {
    if (Object.keys(cart).length === 0) {
      emptyCartMessage.style.display = "block";
      cartItems.appendChild(emptyCartMessage);
    } else {
      emptyCartMessage.style.display = "none";
    }
  }

  if (cartCount) cartCount.textContent = totalQty;
  if (cartTotal) cartTotal.textContent = totalHarga.toLocaleString("id-ID");

  document.querySelectorAll(".quantity-controls").forEach((box) => {
    const qtyText = box.querySelector(".quantity-number");
    const id = box.dataset.id;
    qtyText.textContent = cart[id] ? cart[id].qty : "0";
  });

  if (checkoutBtn) {
    if (Object.keys(cart).length === 0) {
      checkoutBtn.classList.add("disabled");
      checkoutBtn.style.opacity = "0.6";
      checkoutBtn.style.cursor = "not-allowed";
    } else {
      checkoutBtn.classList.remove("disabled");
      checkoutBtn.style.opacity = "1";
      checkoutBtn.style.cursor = "pointer";
    }
  }

  saveCart();
}

// === Tutup Cart Panel (dengan animasi) ===
function closeCartPanel(callback) {
  if (!cartPanel || !cartOverlay) return;

  cartPanel.classList.remove("active");
  cartOverlay.classList.remove("active");
  document.body.classList.remove("no-scroll");

  setTimeout(() => {
    if (callback) callback();
  }, 300);
}

// === Buka / Tutup Panel ===
function attachPanelListeners() {
  if (cartButton && cartPanel && cartOverlay) {
    cartButton.onclick = (e) => {
      e.preventDefault();
      cartPanel.classList.add("active");
      cartOverlay.classList.add("active");
      document.body.classList.add("no-scroll");
    };
  }

  if (closeCartBtn) closeCartBtn.onclick = () => closeCartPanel();
  if (cartOverlay) cartOverlay.onclick = () => closeCartPanel();
}

// === Tombol + / - ===
function attachQuantityListeners() {
  document.querySelectorAll(".quantity-controls").forEach((box) => {
    const plus = box.querySelector(".plus");
    const minus = box.querySelector(".minus");
    const qtyText = box.querySelector(".quantity-number");

    const id = box.dataset.id;
    const name = box.dataset.name;
    const price = parseInt(box.dataset.price || "0", 10);
    const stok = parseInt(box.dataset.stok || "9999", 10);

    if (cart[id]) qtyText.textContent = cart[id].qty;

    plus.onclick = () => {
      let qty = parseInt(qtyText.textContent || "0", 10) + 1;

      if (qty > stok) {
        return closeCartPanel(() => {
          Swal.fire({
            icon: "error",
            title: "Stok Habis!",
            text: `Maaf yaaa, stok ${name} lagi habis nih 🙏`,
            confirmButtonText: "Ok",
            confirmButtonColor: "#7b2cbf",
          });
        });
      }

      qtyText.textContent = qty;
      addToCart(id, name, price, qty);
    };

    minus.onclick = () => {
      let qty = parseInt(qtyText.textContent || "0", 10);
      if (qty > 0) {
        qty--;
        qtyText.textContent = qty;
        addToCart(id, name, price, qty);
      }
    };
  });
}

// === Checkout + Konfirmasi + WhatsApp ===
function attachCheckoutAndClearListeners() {
  if (checkoutBtn) {
    checkoutBtn.onclick = function (ev) {
      ev.preventDefault();

      if (Object.keys(cart).length === 0) {
        return closeCartPanel(() => {
          Swal.fire({
            icon: "warning",
            title: "Keranjang Kosong!",
            text: "Silhakan tambahkan item terlebih dahulu sebelum checkout.",
            confirmButtonText: "Ok",
            confirmButtonColor: "#7b2cbf",
          });
        });
      }

      const buyerName = buyerNameInput?.value.trim();

      if (!buyerName) {
        return closeCartPanel(() => {
          Swal.fire({
            icon: "warning",
            title: "Nama wajib di isi!",
            confirmButtonText: "Ok",
            confirmButtonColor: "#7b2cbf",
          });
        });
      }

      let ringkasanHTML = "<div style='text-align:left'>";
      let total = 0;

      Object.values(cart).forEach((item) => {
        const sub = item.price * item.qty;
        total += sub;
        ringkasanHTML += `
          <div style="display:flex;justify-content:space-between">
            <span>${item.name} x${item.qty}</span>
            <span>Rp${sub.toLocaleString("id-ID")}</span>
          </div>`;
      });

      ringkasanHTML += `
        <hr>
        <div style="display:flex;justify-content:space-between;font-weight:bold">
          <span>Total</span>
          <span>Rp${total.toLocaleString("id-ID")}</span>
        </div>
      </div>`;

      closeCartPanel(() => {
        Swal.fire({
          title: "Konfirmasi Pesanan",
          html: `<p><b>Nama:</b> ${buyerName}</p>${ringkasanHTML}`,
          icon: "question",
          showCancelButton: true,
          confirmButtonText: "Ya, Pesan Sekarang",
          cancelButtonText: "Batal",
          confirmButtonColor: "#7b2cbf",
        }).then((result) => {
          if (!result.isConfirmed) return;

          fetch("process_checkout.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ name: buyerName, cart }),
          })
            .then((res) => res.json())
            .then((data) => {
              if (data.status === "success") {
                clearCartAndResetCounters();
                if (buyerNameInput) buyerNameInput.value = "";

                Swal.fire({
                  icon: "success",
                  title: "Pesanan Diproses!",
                  text: "Mengarahkan ke WhatsApp...",
                  confirmButtonColor: "#7b2cbf",
                }).then(() => {
                  const nomorAdmin = "6282336881878";
                  const isMobile = /Android|iPhone|iPad|iPod/i.test(
                    navigator.userAgent
                  );

                  const waUrl = isMobile
                    ? `whatsapp://send?phone=${nomorAdmin}&text=${encodeURIComponent(
                        data.wa_message
                      )}`
                    : `https://web.whatsapp.com/send?phone=${nomorAdmin}&text=${encodeURIComponent(
                        data.wa_message
                      )}`;

                  window.open(waUrl, "_blank");
                });
              } else {
                Swal.fire({
                  icon: "error",
                  title: "Gagal!",
                  text: data.message,
                  confirmButtonColor: "#7b2cbf",
                });
              }
            });
        });
      });
    };
  }

  if (clearCartBtn) {
    clearCartBtn.onclick = function () {
      if (Object.keys(cart).length === 0) {
        return closeCartPanel(() => {
          Swal.fire({
            icon: "warning",
            title: "Keranjang Kosong",
            text: "Tidak ada item untuk dihapus.",
            confirmButtonColor: "#7b2cbf",
          });
        });
      }

      closeCartPanel(() => {
        Swal.fire({
          icon: "question",
          title: "Hapus Semua?",
          text: "Apakah yakin ingin menghapus semua isi keranjang?",
          showCancelButton: true,
          confirmButtonText: "Ya, hapus",
          cancelButtonText: "Batal",
          confirmButtonColor: "#7b2cbf",
        }).then((result) => {
          if (result.isConfirmed) {
            clearCartAndResetCounters();
            if (buyerNameInput) buyerNameInput.value = "";

            Swal.fire({
              icon: "success",
              title: "Berhasil",
              text: "Keranjang dikosongkan.",
              confirmButtonText: "Ok",
              confirmButtonColor: "#7b2cbf",
            });
          }
        });
      });
    };
  }
}
