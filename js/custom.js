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
