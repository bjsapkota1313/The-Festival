


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


function retrieveParticipatingArtistsData($id){
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


function retrieveDayFromDate(dateData){
    var dayName = dateData.toLocaleString('en-us', {weekday:'long'});
    return dayName;

}

function formatDate(dateData){

    let year = dateData.toLocaleString('en-us', {year:'numeric'});
    let month = dateData.toLocaleString('en-us', {month:'long'});
    let day = dateData.toLocaleString('en-us', {day:'2-digit'});
     var dateStrFormatted = `${day}-${month}-${year}`;
     return dateStrFormatted;

}


function setTranslationOptionsForAvailableEvent(translationOptions){
   translationOptionsList = translationOptions.split(',');
   translationOptionsList = new Set(translationOptionsList);

   translationOptionsList.forEach((option)=> { 
    $('#translationOptions').append('&nbsp;<button id="option" class="btn btn-primary text-white">' + option +'</button>');}
   );

}

function setOrderOfTicketTextDataSections(){
    $('#translationOptions').css('order', '1');
    $('#chooseTicketType').css('order', '2');
    $('#ticketTypes').css('order', '3');
    $('#ticketOptionsControls').css('order', '4');
}

function updateStyleForTicketTextDataSections(){

    $('#translationOptions').css({'margin-top':'20px'});
    $('#chooseTicketType').css({'margin-top':'20px'});
    $('#ticketOptionsControls').css({'margin-top':'40px'});
    $('#ticket').css({'margin-left': '15%'});

}

function displayTicketOptions(availableEventData){
    $('#translationOptions').show();
    $('#chooseTranslationOption').show();
     var translationOptions = availableEventData[8];
     setTranslationOptionsForAvailableEvent(translationOptions);
     setOrderOfTicketTextDataSections();
     updateStyleForTicketTextDataSections();

}


function closeModalWithTicketOptions(title) {

    $('#cancelAddingNewTicket').click(function () {
       $('#ticketData').hide();
    });
}


function retrieveAvailableEventData() {

    let btns = document.querySelectorAll('.buyTicket');

    btns.forEach((btn) => {
        
        btn.addEventListener('click', function(event){

        var id = parseInt($(this).parent().find('#availableEventId').text());

           $.ajax({
            url: "http://localhost/api/AvailableEvents/retrieveAvailableEventData?id=" + id,
            type: "GET",
            dataType: "JSON",
            success: function (jsonStr) {

                var id = jsonStr[0];
                var participatingArtists = retrieveParticipatingArtistsData(id);
                var eventTypeId = jsonStr[2];
                var eventDetails = null;
                 if(participatingArtists == false && (eventTypeId == 1 || eventTypeId == 2)){
                    eventDetails = jsonStr[1];
                 }
                 else {
                    var participatingArtistId = jsonStr[5];
                    eventDetails = retrieveArtistById(participatingArtistId)[1];
                 }

                 var eventName = retrieveEventNameByEventTypeId(eventTypeId);
                 var dateStr = getEventDateById(jsonStr[6])[1];
                 var dateData = new Date(dateStr);
                 var dayName = retrieveDayFromDate(dateData);
                 var dateStrFormatted = formatDate(dateData);

                $("#eventType").text(eventName);
                $("#day").text(dayName);
                $("#dateTime").text(dateStrFormatted);
                
                if (eventTypeId == 1){
                   displayTicketOptions(jsonStr);
                }

                $('#ticketData').show();


            }
        });
    });
});


}


retrieveAvailableEventData();
closeModalWithTicketOptions();
