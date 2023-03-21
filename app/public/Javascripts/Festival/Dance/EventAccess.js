


function retrieveArtistById($id) {

    var res;

    $.ajax({
        url: "http://localhost/api/Artists/retrieveArtistData?id=" + $id,
        type: "GET",
        dataType: "JSON",
        async: false,
        success: function (jsonStr) {
            res = jsonStr;
        }
    });
    return res;
}

function retrieveEventNameByEventTypeId($id) {

    var res;

    $.ajax({
        url: "http://localhost/api/AvailableEvents/retrieveEventNameByEventTypeId?id=" + $id,
        type: "GET",
        dataType: "JSON",
        async: false,
        success: function (jsonStr) {
            res = jsonStr;
        }
    });
    return res;
}


function retrieveParticipatingArtistsData($id) {
    var res;

    $.ajax({
        url: "http://localhost/api/AvailableEvents/retrieveParticipatingArtistsData?id=" + $id,
        type: "GET",
        dataType: "JSON",
        async: false,
        success: function (jsonStr) {
            res = jsonStr;
        }
    });
    return res;

}



function getEventDateById($id) {

    var res;

    $.ajax({
        url: "http://localhost/api/AvailableEvents/getEventDateById?id=" + $id,
        type: "GET",
        dataType: "JSON",
        async: false,
        success: function (jsonStr) {
            res = jsonStr;
        }
    });
    return res;
}



function hideModal() {

    $(document).on("click", function () {

        $(".modal").modal('close');

    }
    );
}



function retrieveAvailableEventData() {
    //alert('test');

    let btns = document.querySelectorAll('.buyTicket');

    btns.forEach((btn) => {

        btn.addEventListener('click', function (event) {

            var id = $(this).parent().find('#availableEventId').text();

            $.ajax({
                url: "http://localhost/api/AvailableEvents/retrieveAvailableEventData?id=" + id,
                type: "GET",
                dataType: "JSON",
                success: function (jsonStr) {

                    var id = jsonStr[0];
                    var participatingArtists = retrieveParticipatingArtistsData(id);
                    var eventTypeId = jsonStr[2];
                    var eventDetails = null;
                    if (participatingArtists == false && (eventTypeId == 1 || eventTypeId == 2)) {
                        eventDetails = jsonStr[1];
                    }
                    else {
                        var participatingArtistId = jsonStr[5];
                        eventDetails = retrieveArtistById(participatingArtistId)[1];
                    }

                    var eventName = retrieveEventNameByEventTypeId(eventTypeId);
                    var dateTime = getEventDateById[6];
                    $("#eventType").text(eventName);
                    $(".modal").modal('show');
                }
            });
        });
    });

}


retrieveAvailableEventData();
hideModal();
