
function setEditingPermissions() {

    $(document).ready(function () {

        $.ajax({
            url: "http://localhost/api/Users/retrieveUserPermissions?id=" + $("#userId").text(),
            type: "GET",
            dataType: "JSON",
            success: function (jsonStr) {
                if (jsonStr == "Customer") {
                    $("#editHomePage").hide();
                }
                else {
                    $("#editHomePage").show();
                }
            }
        });

    });

}


function displayPageEditData() {

    //  alert("test");
    $('#viewEditData').click(function () {
        $('#pageEditData').slideToggle();
    });
}




function retrieveEditorByUserId($userId) {

    var res;
    // $(document).ready(function () {
    // alert('test');

    $.ajax({
        url: "http://localhost/api/Users/retrieveUserById?id=" + $userId,
        type: "GET",
        dataType: "JSON",
        async: false,
        success: function (jsonStr) {
            //  alert(JSON.stringify(jsonStr[1]));

            res = jsonStr;
            //alert(res);

        }
    });
    return res;
    //});

}

function redirectToEditorUrl(title) {

    $('#edit').click(function () {
        window.location = 'http://localhost/page/editor?title=' + title;
    });
}


function retrievePageData() {

    $(document).ready(function () {
        //  alert('test');

        $.ajax({
            url: "http://localhost/api/Pages/retrievePageData?id=" + $("#pageId").text(),
            type: "GET",
            dataType: "JSON",
            success: function (jsonStr) {
                var id = jsonStr[5];
                var user = retrieveEditorByUserId(id);
                var username = user[1];
                var pageTitle = jsonStr[2];
                var editDateTime = jsonStr[4];
                var editDate = editDateTime.split(' ')[0];
                redirectToEditorUrl(pageTitle);

                // alert(user[1]);

                $("#editor").text(username);
                $("#editDate").text(editDate);


                //  alert(JSON.stringify(jsonStr[5]));
            }
        });

    });

}

//var id = $("#userId").text();
setEditingPermissions();
displayPageEditData();
//var user = retrieveEditorByUserId(id);
//alert(user[1]);
retrievePageData();
//redirectToEditorUrl();
