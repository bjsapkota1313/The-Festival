<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5yDEZxPchpFrGUOTavwzG92Nh6CrvZx0"></script>

<div class="historyMainImage">
</div>
<body onload="locate('<?php echo $location . ' ' . $locationPostCode;?>')">
<h1 class="detailHeader">Bigay</h1>
<div class="detailMainContainer">
    <h2> About
    </h2>
    <div class="detailContainer">
        <p class="detailParagraph">The St. Bavo church is an important landmark to Haarlem.
            The church is built in the gothic style of architecture and mentions of a church on its location date back
            to 1307.
            After the wooden structure burnt down sometime in the 14th century,
            the church was renovated and promoted to chapter church in 1479.
            It would be promoted to a cathedral in 1559. Though the church was dedicated to St.
            Bavo at some time before 1500, it would not be an oficial cathedral until halfway through the Protestant
            revolution,
            which means the church was never associated with the term catholic.
        <div class="detailPicture"></div>
    </div>
    <div class="detailContainer">
        <div class="detailPicture"></div>
        <p class="detailParagraph">During the revolution, Haarlem catholics went underground,
            after which they would meet in places called “schuilkerken”.
            One of the most prominant known groups, the st.
            Josephstatie built a new church across from the Janskerk,
            and once it became big enough to be a cathedral, they built a new cathedral on the Leidsevaart.
            Since this cathedral is not dedicated to St. Bavo, the official name for the church is “Grote kerk”,
            which translates to big church. </p>
    </div>
</div>
<div class="detailMainContainer2">
    <h2> Location
    </h2>
    <div class="detailContainer2">
        <div class="detailMap" id="map_canvas"></div>
        <div class="detailPicture"></div>
    </div>
</div>
</body>
<script type="text/javascript">
    function locate(address){
        let geocoder = new google.maps.Geocoder();
        geocoder.geocode({ address: address }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                let lat = results[0].geometry.location.lat();
                let lng = results[0].geometry.location.lng();
                initMap(lat, lng);
            } else {
                alert("Geocode was not successful for the following reason: " + status);
            }
        });
    }
    function initMap(lat, lng){
        var center = new google.maps.LatLng(lat, lng);
        var mapOptions={
            zoom:16,
            center: center,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
        var marker = new google.maps.Marker({
            map: map,
            position: center
        });
    }
</script>

