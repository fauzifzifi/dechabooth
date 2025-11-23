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

  // FORM VALID → submit
  form.submit();
}

/**
 * Confirm delete dengan SweetAlert2
 */
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

/**
 * Menampilkan alert sukses / error dari session
 */
document.addEventListener("DOMContentLoaded", function () {
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
