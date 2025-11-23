// to get current year
function getYear() {
  var currentDate = new Date();
  var currentYear = currentDate.getFullYear();
  document.querySelector("#displayYear").innerHTML = currentYear;
}

getYear();

// slick slider
$(".menu_container").slick({
  infinite: true,
  center: true,
  slidesToShow: 3,
  slidesToScroll: 1,
  responsive: [
    {
      breakpoint: 991,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1,
      },
    },
    {
      breakpoint: 576,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
      },
    },
  ],
});

/** google_map js **/

function myMap() {
  // Titik lokasi kamu
  var myLocation = { lat: -7.522973, lng: 111.903903 };

  // Membuat peta di elemen dengan id "googleMap"
  var map = new google.maps.Map(document.getElementById("googleMap"), {
    center: myLocation,
    zoom: 18, // ubah angka ini untuk memperbesar/memperkecil tampilan
  });

  // Menambahkan marker di lokasi kamu
  var marker = new google.maps.Marker({
    position: myLocation,
    map: map,
    title: "Lokasi Decha Booth", // teks yang muncul saat marker diklik
  });
}

// ==== VALIDASI INPUT CONTACT US SEBELUM SUBMIT ====
const contactForm = document.getElementById("contactForm");

if (contactForm) {
  contactForm.addEventListener("submit", function (e) {
    const nama = document.querySelector("input[name='nama']").value.trim();
    const telepon = document
      .querySelector("input[name='telepon']")
      .value.trim();
    const email = document.querySelector("input[name='email']").value.trim();
    const pesan = document.querySelector("textarea[name='pesan']").value.trim();

    if (!nama || !telepon || !email || !pesan) {
      e.preventDefault();

      Swal.fire({
        icon: "warning",
        title: "Form kosong!",
        text: "Isi form sebelum mengirim pesan.",
        confirmButtonColor: "#7b2cbf",
      });

      return false;
    }
  });
}
