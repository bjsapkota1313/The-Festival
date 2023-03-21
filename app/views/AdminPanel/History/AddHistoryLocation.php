<!--<section class="home-section">-->
<!--    <div class="container pb-3 pt-3">-->
<!--        <div class="row">-->
<!--            <div class="col-md-12">-->
<!--                <h1> --><?//= $title?><!--</h1>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="container">-->
<!--        <div class="panel panel-primary">-->
<!--            <div class="panel-heading">-->
<!--                <h2 class="panel-title">Add Tour Address</h2>-->
<!--            </div>-->
<!--            <div class="panel-body">-->
<!--                <input id="autocomplete" placeholder="Enter Tour address" onFocus="geolocate()" type="text"-->
<!--                       class="form-control">-->
<!--                <div id="address">-->
<!--                    <div class="row">-->
<!--                        <div class="col-md-6">-->
<!--                            <label class="control-label">Street Number</label>-->
<!--                            <input class="form-control" id="street_number" disabled="true">-->
<!--                        </div>-->
<!--                        <div class="col-md-6">-->
<!--                            <label class="control-label">Street Name</label>-->
<!--                            <input class="form-control" id="route" disabled="true">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="row">-->
<!--                        <div class="col-md-6">-->
<!--                            <label class="control-label">City</label>-->
<!--                            <input class="form-control field" id="locality" disabled="true">-->
<!--                        </div>-->
<!--                        <div class="col-md-6">-->
<!--                            <label class="control-label">State</label>-->
<!--                            <input class="form-control" id="administrative_area_level_1" disabled="true">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="row">-->
<!--                        <div class="col-md-6">-->
<!--                            <label class="control-label">Post Code</label>-->
<!--                            <input class="form-control" id="postal_code" disabled="true">-->
<!--                        </div>-->
<!--                        <div class="col-md-6">-->
<!--                            <label class="control-label">Country</label>-->
<!--                            <input class="form-control" id="country" disabled="true">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</section>-->
<section class="home-section">
    <div class="container pb-3 pt-3">
        <div class="row">
            <div class="col-md-12">
                <h1><?= $title ?></h1>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2 class="panel-title">Add Tour Address</h2>
            </div>
            <div class="panel-body">
                <form method="POST">
                    <input id="autocomplete" placeholder="Enter Tour address" onFocus="geolocate()" type="text"
                           class="form-control">
                    <div id="address">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="control-label">Street Number</label>
                                <input class="form-control" id="street_number" name="tourStreetNumber" disabled="true">
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">Street Name</label>
                                <input class="form-control" id="route" name="tourStreetName" disabled="true">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="control-label">City</label>
                                <input class="form-control field" id="locality" name="tourCity"disabled="true">
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">State</label>
                                <input class="form-control" id="administrative_area_level_1" disabled="true">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="control-label">Post Code</label>
                                <input class="form-control" id="postal_code" name="tourPostCode"disabled="true">
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">Country</label>
                                <input class="form-control" id="country" name="tourCountry" disabled="true">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3" name="addNewTourLocation">Submit</button>
                </form>
            </div>
        </div>
    </div>
</section>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
        integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
        crossorigin="anonymous"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<script src="auto-complete.js"></script>

<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5yDEZxPchpFrGUOTavwzG92Nh6CrvZx0&libraries=places&callback=initAutocomplete">

</script>
<script>
    var placeSearch, autocomplete;
    var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
    };

    function initAutocomplete() {
        // Create the autocomplete object, restricting the search to Netherlands
        autocomplete = new google.maps.places.Autocomplete(
            document.getElementById('autocomplete'), {
                types: ['geocode'],
                componentRestrictions: {country: 'NL'}
            });

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);
    }

    function fillInAddress() {
// Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();
0
        for (var component in componentForm) {
            document.getElementById(component).value = '';
            document.getElementById(component).disabled = false;
        }

// Get each component of the address from the place details
// and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            if (componentForm[addressType]) {
                var val = place.address_components[i][componentForm[addressType]];
                document.getElementById(addressType).value = val;
            }
        }
    }

    // Bias the autocomplete object to the user's geographical location,
    // as supplied by the browser's 'navigator.geolocation' object.
    function geolocate() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var geolocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                var circle = new google.maps.Circle({
                    center: geolocation,
                    radius: position.coords.accuracy
                });
                autocomplete.setBounds(circle.getBounds());
            });
        }
    }
</script>
