

function showPasswordFields() {
    $('#changePasswordCheckBox').click(function () {
        $('#password-fields').slideToggle();
    });
}


function submitAccountInfo() {

    $(document).ready(function () {

        $("#updateForm").on("submit", function (event) {
            if ($("#changePasswordCheckBox").prop("checked")) {
                var newPassword = $("#newPassword").val();
                var confirmPassword = $("#confirmPassword").val();

                if (newPassword !== confirmPassword) {
                    $("#validationMessage").text("Passwords Do Not Match!");
                    $("#submit").prop("disabled", true);
                    event.preventDefault();

                }
                else {
                    event.currentTarget.submit();
                }
            }
        });
    });
}

function enableSubmitButton() {

    $("#newPassword").on("input", function (e) {
        $("#submit").prop("disabled", false);
    });
    $("#confirmPassword").on("input", function (e) {
        $("#submit").prop("disabled", false);
    });

}


showPasswordFields();
submitAccountInfo();
enableSubmitButton();


