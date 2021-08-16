<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ramada Cancún - Hotel Adhara</title>
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500&family=Montserrat:wght@300&display=swap" rel="stylesheet">

    <!-- Icons -->
    <script src="https://kit.fontawesome.com/8d420a663d.js" crossorigin="anonymous"></script>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/ramada.css')}}">

    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGp4a2I1yctVHpeRE4SyF_8JQmLtMijdw&callback=initMap&libraries=&v=weekly"
      defer
    ></script>
</head>
<body>
  <div class="container" id="close-ramada">
    <p class="body-ramada">Gracias por elegirnos, le otorgamos una <strong>mejor categoría</strong> en nuestro hotel hermano:</p>
    <img src="{{ asset('img/logos/logo_adhara.png') }}" alt="Hotel Adhara Cancún" id="logo">
    <p class="body-ramada"><strong>Respetando tarifa</strong> del Hotel Ramada Cancún</p>
    <img src="{{ asset('img/items/adhara_facilities.png') }}" alt="Hotel Adhara Cancún Facilities" id="facilities">
    <p class="body-ramada">A sólo cinco minutos:</p>
    <div id="map"></div>
    <div id="footer">
      <img src="{{ asset('img/logos/ubicacion.png') }}" alt="Direccion Hotel Adhara Cancún">
      <p>Dirección</p>
      <p>Av. Carlos Náder 1,2,3 SM.1, MZ.2, Cancún,</p>
      <p class="endQuote">Quintana Roo, México.</p>
      <img src="{{ asset('img/logos/whatsapp.png') }}" alt="WhatsApp Hotel Adhara Cancún">
      <p>Teléfono</p>
      <p><a href="">(998) 881 65 00</a></p>
      <p class="endQuote"><a href="">01 800 711-15-31 (México)</a></p>
      <img src="{{ asset('img/logos/whats.png') }}" alt="WhatsApp Hotel Adhara Cancun">
      <p>WhatsApp</p>
      <p><a href="https://api.whatsapp.com/send?text=Quiero_Solicitar_Informacion&phone=5219981221861&abid=5219981221861" target="_blank">998 122 18 61</a></p>
      <ul class="d-flex justify-content-center">
        <li>
          <a href="https://twitter.com/adharacancun" target="_blank"><img src="{{ asset('img/logos/twitter.png') }}" alt="Twitter Adhara Cancún"></a>
        </li>
        <li>
          <a href="https://www.instagram.com/adharacancun/" target="_blank"><img src="{{ asset('img/logos/instagram.png') }}" alt="Instagram Adhara Cancún"></a>
        </li>
        <li>
          <a href="https://www.facebook.com/HotelAdharaCancun" target="_blank"><img src="{{ asset('img/logos/facebook.png') }}" alt="Facebook Adhara Cancún"></a>
        </li>
      </ul>
    </div>
  </div>
    
</body>


<script type="text/javascript">
function initMap() {
    const directionsService = new google.maps.DirectionsService();
    const directionsRenderer = new google.maps.DirectionsRenderer();
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 7,
        center: { lat: 41.85, lng: -87.65 },
    });
    directionsService.route
    (
        {
            origin: {
            query: 'Ramada Cancun City, Avenida Yaxchilán, 22, Cancún, Q.R.',
            },
            destination: {
            query: 'Hotel Adhara Hacienda Cancun, Avenida Carlos Nader, Bancos, 1, Cancún, Quintana Roo',
            },
            travelMode: google.maps.TravelMode.DRIVING,
        },
        (response, status) => {
            if (status === "OK") {
            directionsRenderer.setDirections(response);
            } else {
            window.alert("Directions request failed due to " + status);
            }
        }
    );
  directionsRenderer.setMap(map);
}
</script>
</html>