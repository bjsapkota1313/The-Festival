


function retrieveArtistById($id) {

    var res; 

    $.ajax({
        url: "http://localhost/api/AvailableEvents/retrieveArtistData?id=" + $id,
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


function setTranslationOptionsForAvailableEvent(translationOptions) {
    translationOptionsList = translationOptions.split(',');
    translationOptionsList = new Set(translationOptionsList);
    var counter = 0;
    translationOptionsList.forEach((option) => {
        counter++;
        $('#translationOptions').append('&nbsp;<button id="option" class="option' + counter + ' btn btn-primary text-white"  value="' + option + '">' + option + '</button><span id="optionId" style="display:none"></span>');
    }
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
    $("#translationOptions").empty();
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


function removeTranslationOptions() {

       $('#chooseTranslationOption').hide();
       $('#translationOptions').empty();   
}



function retrievePreviousTicketId() {

    var res;

    $.ajax({
        url: "http://localhost/api/Tickets/retrievePreviousTicketId",
        type: "GET",
        dataType: "JSON",
        async: false,
        success: function (jsonStr) {
            res = jsonStr;

        }
    });
    return res;
}



function retrievePreviousOrderId() {

    var res;

    $.ajax({
        url: "http://localhost/api/ShopOrders/retrievePreviousOrderId",
        type: "GET",
        dataType: "JSON",
        async: false,
        success: function (jsonStr) {
            res = jsonStr;

        }
    });
    return res;
}


function retrievePreviousShoppingBasket() {

    var res;

    $.ajax({
        url: "http://localhost/api/ShoppingBaskets/retrievePreviousShoppingBasket",
        type: "GET",
        dataType: "JSON",
        async: false,
        success: function (jsonStr) {
            res = jsonStr;

        }
    });
    return res;
}




function retrievePreviousShoppingBasketId() {

    var res;

    $.ajax({
        url: "http://localhost/api/ShoppingBaskets/retrievePreviousShoppingBasketId",
        type: "GET",
        dataType: "JSON",
        async: false,
        success: function (jsonStr) {
            res = jsonStr;

        }
    });
    return res;
}



function retrieveBasketOfUser(userId) {

    var res;

    $.ajax({
        url: "http://localhost/api/ShoppingBaskets/retrieveBasketOfUser?id=" + userId,
        type: "GET",
        dataType: "JSON",
        async: false,
        success: function (jsonStr) {
            res = jsonStr;

        }
    });
    return res;
}

function checkExistenceOfShoppingBasketForUser(userId) {

    var res;

    $.ajax({
        url: "http://localhost/api/ShoppingBaskets/checkExistenceOfBasketForUser?id=" + userId,
        type: "GET",
        dataType: "JSON",
        async: false,
        success: function (jsonStr) {
            res = jsonStr;

        }
    });
    return res;
}




let update = (newlist, value) => {
    newlist.push(value);
};



function retrieveTranslationOptionId() {
    $(".option1").on('click', function () {
        $("#optionId").text('1');

    });
    $(".option2").on('click', function () {
        $("#optionId").text('2');

    });

}


function retrieveLanguageSelected(value) {

    var listItems = document.querySelector('#translationOptions').querySelectorAll("*");
    var options = new Array();


    let selectedOption = (newList, value) => update(newList, value);

    if (value == 1) {
        selectedOption(options, listItems[0].attributes[2].value);
    }

    else if (value == 2) {

        selectedOption(options, listItems[2].attributes[2].value);
    }

    else if (value == 3) {

        selectedOption(options, listItems[4].attributes[2].value);
    }

    return options[0];
}



function retrieveTicketType() {

    return $('#ticketTypes option:selected').val();
}


function createTicketInstance(availableEventId, languageSelected, ticketType, orderId) {
    var ticketData = {};
    var previousTicketId = retrievePreviousTicketId();
    ticketData.ticketId = ++previousTicketId;
    ticketData.availableEventId = availableEventId;
    ticketData.ticketOptions = ticketType + ";" + languageSelected;
    ticketData.orderId = orderId;

    return ticketData;
}



function createOrderInstance() {
    var orderData = {};
    var previousOrderId = retrievePreviousOrderId();
    orderData.orderId = ++previousOrderId;
    orderData.userId = $("#userId").text();
    orderData.orderDate = new Date(Date.now()).toLocaleString();
    orderData.billId = 1;

    return orderData;
}



function createShoppingBasketInstance() {
    var shoppingBasketData = {};
    var previousShoppingBasketId = retrievePreviousShoppingBasketId();
    shoppingBasketData.shoppingBasketId = ++previousShoppingBasketId;
    shoppingBasketData.userId = $("#userId").text();
    shoppingBasketData.billId = 1;

    return shoppingBasketData;
}


function addShoppingBasket(shoppingBasketData) {
    
    $.ajax({
        type: "POST",
        url: "http://localhost/api/ShoppingBaskets/addShoppingBasket",
        data: shoppingBasketData,
        success: function () {
            alert('addedShoppingBasket');
        }
    });
}



function addOrder(orderData) {
    
        $.ajax({
            type: "POST",
            url: "http://localhost/api/ShopOrders/addOrder",
            data: orderData,
            success: function () {
            }
        });
}


function addShoppingBasket(shoppingBasketData) {
    
    $.ajax({
        type: "POST",
        url: "http://localhost/api/ShoppingBaskets/addShoppingBasket",
        data: shoppingBasketData,
        success: function () {
        }
    });
}


function addTicketToCart(availableEventId, translationOptionId) {

    $("#addToShoppingBasket").on('click', function (event) {
        var translationOptionId = parseInt($("#optionId").text(), 10);
        var languageSelected = retrieveLanguageSelected(translationOptionId);
        var ticketType = retrieveTicketType();
        var userId = $("#userId").text();
        var orderData = createOrderInstance();
        var shoppingBasketExists = checkExistenceOfShoppingBasketForUser(userId);
        if (shoppingBasketExists == false){
            var shoppingBasketData = createShoppingBasketInstance();
            addShoppingBasket(shoppingBasketData);
            addOrder(orderData);
        }
        
        else {
            var previousShoppingBasket = retrievePreviousShoppingBasket();
            orderData.billId = previousShoppingBasket.billId;
            addOrder(orderData);

        }
        var TicketData = createTicketInstance(availableEventId, ticketType, languageSelected, orderData.billId);

        $.ajax({
            type: "POST",
            url: "http://localhost/api/Tickets/addTicket",
            data: TicketData,
            success: function () {
            }
        });

    });
}




function retrieveAvailableEventData() {

    let btns = document.querySelectorAll('.buyTicket');

    btns.forEach((btn) => {

        btn.addEventListener('click', function (event) {

            var availableEventId = parseInt($(this).parent().find('#availableEventId').text());

            $.ajax({
                url: "http://localhost/api/AvailableEvents/retrieveAvailableEventData?id=" + availableEventId,
                type: "GET",
                dataType: "JSON",
                success: function (jsonStr) {
                    var participatingArtists = retrieveParticipatingArtistsData(availableEventId);
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
                    var dateStr = getEventDateById(jsonStr[6])[1];
                    var dateData = new Date(dateStr);
                    var dayName = retrieveDayFromDate(dateData);
                    var dateStrFormatted = formatDate(dateData);

                    $("#eventType").text(eventName);
                    $("#day").text(dayName);
                    $("#dateTime").text(dateStrFormatted);

                    if (eventTypeId == 1) {
                        displayTicketOptions(jsonStr);
                    }
                    else if (eventTypeId == 2) {
                        removeTranslationOptions();
                    }

                    $('#ticketData').show();

                    retrieveTranslationOptionId();
                    addTicketToCart(availableEventId);



                }
            });
        });
    });





}


retrieveAvailableEventData();
closeModalWithTicketOptions();
