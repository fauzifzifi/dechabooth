// === Inisialisasi keranjang dari localStorage ===
let cart = JSON.parse(localStorage.getItem("cart")) || {};

// Elemen DOM (akan diambil saat DOMContentLoaded)
let cartCount,
  cartPanel,
  cartItems,
  cartTotal,
  cartButton,
  closeCartBtn,
  checkoutBtn,
  clearCartBtn,
  cartOverlay,
  emptyCartMessage;

// ===== Helper: tunggu elemen DOM siap dan pasang semua listener di sini =====
document.addEventListener("DOMContentLoaded", () => {
  console.log("DOM Content Loaded - Initializing cart...");

  // Ambil elemen (sesuaikan id di HTML)
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

  // Pasang event listeners & update awal
  attachQuantityListeners();
  attachPanelListeners();
  attachCheckoutAndClearListeners();
  updateCart();
});

// === Simpan ke localStorage ===
function saveCart() {
  localStorage.setItem("cart", JSON.stringify(cart));
}

// === Fungsi menambah/mengupdate item ke keranjang ===
function addToCart(name, price, qty) {
  if (qty === 0) {
    delete cart[name];
  } else {
    cart[name] = { price, qty };
  }
  updateCart();
}

// === Fungsi untuk mengosongkan keranjang dan reset counter ===
function clearCartAndResetCounters() {
  cart = {};
  localStorage.removeItem("cart");
  document
    .querySelectorAll(".quantity-number")
    .forEach((el) => (el.textContent = "0"));
  updateCart();
  console.log("Keranjang telah dikosongkan");
}

// === Fungsi update keranjang (isi + total) ===
function updateCart() {
  let totalQty = 0;
  let totalHarga = 0;
  if (!cartItems) return;

  cartItems.innerHTML = "";

  for (const [name, item] of Object.entries(cart)) {
    const subtotal = item.price * item.qty;
    totalHarga += subtotal;
    totalQty += item.qty;

    const div = document.createElement("div");
    div.className = "cart-item";
    div.innerHTML = `
      <span>${name} x${item.qty}</span>
      <span>Rp${subtotal.toLocaleString("id-ID")}</span>
    `;
    cartItems.appendChild(div);
  }

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
    const name = box.dataset.name;
    if (cart[name] && cart[name].qty > 0) qtyText.textContent = cart[name].qty;
    else qtyText.textContent = "0";
  });

  // PERBAIKAN: Ubah styling tombol checkout berdasarkan isi keranjang
  if (checkoutBtn) {
    if (Object.keys(cart).length === 0) {
      // Keranjang kosong - tombol aktif tapi dengan style disabled
      checkoutBtn.disabled = false; // Biarkan bisa diklik
      checkoutBtn.classList.add("disabled");
      checkoutBtn.style.opacity = "0.6";
      checkoutBtn.style.cursor = "not-allowed";
    } else {
      // Keranjang ada isi - tombol aktif penuh
      checkoutBtn.disabled = false;
      checkoutBtn.classList.remove("disabled");
      checkoutBtn.style.opacity = "1";
      checkoutBtn.style.cursor = "pointer";
    }
  }

  saveCart();
}

// ===== Tutup panel dengan callback =====
function closeCartPanel(callback) {
  if (!cartPanel || !cartOverlay) {
    if (typeof callback === "function") callback();
    return;
  }

  cartPanel.classList.remove("active");
  cartOverlay.classList.remove("active");
  document.body.classList.remove("no-scroll");

  let fired = false;
  const onTransitionEnd = (ev) => {
    if (ev.target === cartPanel) {
      fired = true;
      cartPanel.removeEventListener("transitionend", onTransitionEnd);
      if (typeof callback === "function") callback();
    }
  };

  cartPanel.addEventListener("transitionend", onTransitionEnd);

  setTimeout(() => {
    if (!fired) {
      cartPanel.removeEventListener("transitionend", onTransitionEnd);
      if (typeof callback === "function") callback();
    }
  }, 500);
}

// ===== Pasang listener panel (buka/tutup) =====
function attachPanelListeners() {
  if (cartButton && cartPanel && cartOverlay) {
    cartButton.addEventListener("click", (e) => {
      e.preventDefault();
      cartPanel.classList.add("active");
      cartOverlay.classList.add("active");
      document.body.classList.add("no-scroll");
    });
  }

  if (closeCartBtn) {
    closeCartBtn.addEventListener("click", () => closeCartPanel());
  }

  if (cartOverlay) {
    cartOverlay.addEventListener("click", () => closeCartPanel());
  }
}

// ===== Pasang listener pada tombol + / - produk =====
function attachQuantityListeners() {
  document.querySelectorAll(".quantity-controls").forEach((box) => {
    const plus = box.querySelector(".plus");
    const minus = box.querySelector(".minus");
    const qtyText = box.querySelector(".quantity-number");
    const name = box.dataset.name;
    const price = parseInt(box.dataset.price || "0", 10);
    const stok = parseInt(box.dataset.stok || "9999", 10);

    if (cart[name]) qtyText.textContent = cart[name].qty;

    if (plus) {
      plus.addEventListener("click", () => {
        let qty = parseInt(qtyText.textContent || "0", 10) + 1;
        if (qty > stok) {
          closeCartPanel(() => {
            if (typeof Swal !== "undefined") {
              Swal.fire({
                icon: "error",
                title: "Stok Tidak Cukup",
                text: `Stok ${name} lagi habis nihh, maaf yaaa :)`,
                confirmButtonColor: "#7b2cbf",
              });
            } else {
              alert(`Stok ${name} hanya ${stok} tersedia.`);
            }
          });
          return;
        }
        qtyText.textContent = qty;
        addToCart(name, price, qty);
      });
    }

    if (minus) {
      minus.addEventListener("click", () => {
        let qty = parseInt(qtyText.textContent || "0", 10);
        if (qty > 0) {
          qty--;
          qtyText.textContent = qty;
          addToCart(name, price, qty);
        }
      });
    }
  });
}

// ===== Pasang listener Checkout & Clear =====
function attachCheckoutAndClearListeners() {
  if (checkoutBtn) {
    console.log("Attaching checkout listener to button:", checkoutBtn);

    // Hapus atribut disabled dari HTML dan atur melalui JavaScript
    checkoutBtn.disabled = false;

    checkoutBtn.addEventListener("click", function (ev) {
      ev.preventDefault();
      console.log("Checkout button clicked!");
      console.log("Cart contents:", cart);
      console.log("Cart keys length:", Object.keys(cart).length);

      // Cek apakah keranjang kosong
      if (Object.keys(cart).length === 0) {
        console.log("Cart is empty - showing alert");

        // Tutup panel dan tampilkan alert
        closeCartPanel(() => {
          if (typeof Swal !== "undefined") {
            Swal.fire({
              icon: "warning",
              title: "Keranjang Kosong!",
              text: "Silhakan tambahkan item terlebih dahulu sebelum checkout.",
              confirmButtonColor: "#7b2cbf",
            });
          } else {
            alert(
              "Keranjang kosong! Silhakan tambahkan item terlebih dahulu sebelum checkout."
            );
          }
        });
        return;
      }

      // Lanjutkan proses checkout jika keranjang tidak kosong
      console.log("Proceeding with checkout...");
      let pesan = "Halo, saya ingin memesan:\n";
      let total = 0;

      for (const [name, item] of Object.entries(cart)) {
        const subtotal = item.price * item.qty;
        pesan += `- ${name} x${item.qty} = Rp${subtotal.toLocaleString(
          "id-ID"
        )}\n`;
        total += subtotal;
      }

      pesan += `\nTotal: Rp${total.toLocaleString("id-ID")}\n\nTerima kasih!`;
      const nomor = "6282336881878";
      const encodedPesan = encodeURIComponent(pesan);

      // Update stok
      fetch("update_stok.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(
          Object.entries(cart).map(([name, item]) => ({
            name,
            qty: item.qty,
          }))
        ),
      }).catch((err) => {
        console.error("Gagal update stok:", err);
      });

      // Kosongkan cart dan buka WA
      clearCartAndResetCounters();

      closeCartPanel(() => {
        if (typeof Swal !== "undefined") {
          Swal.fire({
            icon: "success",
            title: "Pesanan Dikirim!",
            text: "Anda akan diarahkan ke WhatsApp untuk menyelesaikan pesanan.",
            confirmButtonText: "Lanjutkan",
            confirmButtonColor: "#7b2cbf",
          }).then(() => {
            const isMobile = /Android|iPhone|iPad|iPod/i.test(
              navigator.userAgent
            );
            const waUrl = isMobile
              ? `whatsapp://send?phone=${nomor}&text=${encodedPesan}`
              : `https://web.whatsapp.com/send?phone=${nomor}&text=${encodedPesan}`;
            window.open(waUrl, "_blank");
          });
        } else {
          alert("Pesanan dikirim! Anda akan diarahkan ke WhatsApp.");
          const isMobile = /Android|iPhone|iPad|iPod/i.test(
            navigator.userAgent
          );
          const waUrl = isMobile
            ? `whatsapp://send?phone=${nomor}&text=${encodedPesan}`
            : `https://web.whatsapp.com/send?phone=${nomor}&text=${encodedPesan}`;
          window.open(waUrl, "_blank");
        }
      });
    });
  }

  if (clearCartBtn) {
    clearCartBtn.addEventListener("click", function () {
      console.log("Clear cart button clicked");

      if (Object.keys(cart).length === 0) {
        closeCartPanel(() => {
          if (typeof Swal !== "undefined") {
            Swal.fire({
              icon: "warning",
              title: "Keranjang Kosong",
              text: "Tidak ada item untuk dihapus.",
              confirmButtonColor: "#7b2cbf",
            });
          } else {
            alert("Keranjang masih kosong.");
          }
        });
        return;
      }

      // Konfirmasi hapus semua
      closeCartPanel(() => {
        if (typeof Swal !== "undefined") {
          Swal.fire({
            icon: "question",
            title: "Hapus Semua?",
            text: "Apakah yakin ingin menghapus semua isi keranjang?",
            showCancelButton: true,
            confirmButtonText: "Ya, hapus",
            cancelButtonText: "Batal",
            confirmButtonColor: "#7b2cbf",
            cancelButtonColor: "#6c757d",
          }).then((result) => {
            if (result.isConfirmed) {
              clearCartAndResetCounters();
              Swal.fire({
                icon: "success",
                title: "Berhasil",
                text: "Keranjang berhasil dikosongkan.",
                confirmButtonColor: "#7b2cbf",
              });
            }
          });
        } else {
          // fallback confirm
          if (confirm("Yakin ingin menghapus semua isi keranjang?")) {
            clearCartAndResetCounters();
            alert("Keranjang berhasil dikosongkan.");
          }
        }
      });
    });
  }
}
