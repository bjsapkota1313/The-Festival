<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5yDEZxPchpFrGUOTavwzG92Nh6CrvZx0"></script>

<div class="historyMainImage">
</div>
<body onload="locate('<?php echo $location . ' ' . $locationPostCode; ?>')">
<?php
foreach ($getLocationParagraphsById as $getLocationParagraphById) {
    ?>
    <h1 class="detailHeader"><?= $getLocationParagraphById->getLocationName() ?></h1><br>
<?php } ?>
<div class="detailMainContainer">
    <h2> About</h2>
    <div class="detailContainer">

            <div class="detailParagraph">
                <p><?= $getLocationParagraphsById->getHistoryP1()?></p><br>
            </div>

        <div class="detailPicture">
            <img src="<?= $this->getImageFullPath($tourImage['banner'][0]) ?>"
                 class="border hover-zoom" style="border-radius:50%;height: 409px;width:409px">
        </div>
    </div>
    <div class="detailContainer">
        <div class="detailPicture"></div>
        <?php
        foreach ($getLocationParagraphsById as $getLocationParagraphById) {
            ?>
            <p class="detailParagraph"><?= $getLocationParagraphById->getHistoryP2() ?></p><br>
        <?php } ?>
        <!--        <p class="detailParagraph">During the revolution, Haarlem catholics went underground,-->
        <!--            after which they would meet in places called “schuilkerken”.-->
        <!--            One of the most prominant known groups, the st.-->
        <!--            Josephstatie built a new church across from the Janskerk,-->
        <!--            and once it became big enough to be a cathedral, they built a new cathedral on the Leidsevaart.-->
        <!--            Since this cathedral is not dedicated to St. Bavo, the official name for the church is “Grote kerk”,-->
        <!--            which translates to big church. </p>-->
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
    function locate(address) {
        let geocoder = new google.maps.Geocoder();
        geocoder.geocode({address: address}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                let lat = results[0].geometry.location.lat();
                let lng = results[0].geometry.location.lng();
                initMap(lat, lng);
            } else {
                alert("Geocode was not successful for the following reason: " + status);
            }
        });
    }

    function initMap(lat, lng) {
        var center = new google.maps.LatLng(lat, lng);
        var mapOptions = {
            zoom: 16,
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

