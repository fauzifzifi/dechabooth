// ==========================
// SIDEBAR TOGGLE SYSTEM
// ==========================

document.addEventListener("DOMContentLoaded", function () {
  const sidebar = document.getElementById("azSidebar");
  const overlay = document.getElementById("azSidebarOverlay");
  const toggle = document.getElementById("azSidebarToggle");
  const btnClose = document.getElementById("azSidebarClose");

  const mq = window.matchMedia("(max-width: 768px)");

  if (!sidebar || !overlay || !toggle) {
    console.warn("Sidebar elements not found.");
    return;
  }

  function isMobile() {
    return mq.matches;
  }

  function openSidebar() {
    if (!isMobile()) return;

    sidebar.classList.add("mobile-open");
    overlay.classList.add("active");
    document.body.classList.add("az-no-scroll");

    toggle.setAttribute("aria-expanded", "true");
    overlay.setAttribute("aria-hidden", "false");
  }

  function closeSidebar() {
    sidebar.classList.remove("mobile-open");
    overlay.classList.remove("active");
    document.body.classList.remove("az-no-scroll");

    toggle.setAttribute("aria-expanded", "false");
    overlay.setAttribute("aria-hidden", "true");
  }

  /* Toggle click */
  toggle.addEventListener("click", function () {
    if (!isMobile()) return;

    if (sidebar.classList.contains("mobile-open")) closeSidebar();
    else openSidebar();
  });

  /* Close button */
  if (btnClose) {
    btnClose.addEventListener("click", closeSidebar);
  }

  /* Overlay click to close */
  overlay.addEventListener("click", closeSidebar);

  /* ESC key close */
  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape" && sidebar.classList.contains("mobile-open")) {
      closeSidebar();
    }
  });

  /* Auto-reset when back to desktop */
  window.addEventListener("resize", function () {
    if (!isMobile()) {
      closeSidebar(); // pastikan sidebar normal di desktop
    }
  });
});

// === AUTO ACTIVE MENU ===
document.addEventListener("DOMContentLoaded", () => {
  const currentPage = window.location.pathname.split("/").pop(); // nama file
  const menuLinks = document.querySelectorAll(".sidebar ul li a");

  menuLinks.forEach((link) => {
    const linkPage = link.getAttribute("href");

    if (linkPage === currentPage) {
      link.parentElement.classList.add("active");
    }
  });
});

/* =========================
   ALERT + VALIDASI FORM
========================= */

function validasiForm() {
  const form = document.querySelector("form");
  if (!form) return;

  let nama = (
    form.querySelector('[name="nama_menu"]') || { value: "" }
  ).value.trim();
  let harga = (
    form.querySelector('[name="harga"]') || { value: "" }
  ).value.trim();
  let jenis = (
    form.querySelector('[name="jenis"]') || { value: "" }
  ).value.trim();
  let stok = (
    form.querySelector('[name="stok"]') || { value: "" }
  ).value.trim();

  if (nama === "" || harga === "" || jenis === "" || stok === "") {
    Swal.fire({
      icon: "warning",
      title: "Form kosong!",
      text: "Isi semua data terlebih dahulu.",
      confirmButtonText: "OK",
      confirmButtonColor: "#7b2cbf",
    });
    return;
  }

  form.submit();
}

function hapusMenu(id) {
  Swal.fire({
    title: "Hapus menu ini?",
    text: "Data tidak dapat dikembalikan!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Ya, hapus!",
    cancelButtonText: "Batal",
    confirmButtonColor: "#7b2cbf",
    cancelButtonColor: "#6c757d",
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = "manage_menu.php?delete=" + id;
    }
  });
}

document.addEventListener("DOMContentLoaded", function () {
  try {
    initSidebar();
  } catch (err) {
    console.warn("Sidebar init failed:", err);
  }

  const body = document.body;
  const success = body.getAttribute("data-success") || "";
  const error = body.getAttribute("data-error") || "";

  if (success.trim() !== "") {
    Swal.fire({
      icon: "success",
      title: "Berhasil!",
      text: success,
      confirmButtonText: "OK",
      confirmButtonColor: "#7b2cbf",
    });
  }

  if (error.trim() !== "") {
    Swal.fire({
      icon: "error",
      title: "Gagal!",
      text: error,
      confirmButtonText: "OK",
      confirmButtonColor: "#7b2cbf",
    });
  }
});
