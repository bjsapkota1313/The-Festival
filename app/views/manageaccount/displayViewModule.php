<?

function DisplayPage($currentUser)
{
    if ($currentUser->getRole() == Roles::Customer()) {
        echo '<script >document.getElementById("manageUsersLink").style.display = "none";</script>';
    }
}


function DisplayManageAccountPage($currentUser)
{
    if ($currentUser->getRole() == Roles::Customer()) {
        echo $currentUser->getId();
        echo '<script >document.getElementById("userRole").style.display = "none";</script>';
    }
}


function showPasswordFields()
{

    echo "<script > 
    $('#changePasswordCheckBox').click(function(){
    $('#password-fields').slideToggle();
    });</script>";

}


function submitAccountInfo()
{

    echo '<script > 
    $(document).ready(function(){   


        $("#updateForm").on("submit",function(event){ 
            if ($("#changePasswordCheckBox").prop("checked"))  {
    var newPassword = $("#newPassword").val();
    var confirmPassword = $("#confirmPassword").val();

    if(newPassword !== confirmPassword){
    $("#validationMessage").text("Passwords Do Not Match!");
        $("#submit").prop("disabled", true);
        event.preventDefault();
    
    }    
    else {
        event.currentTarget.submit();   
    }
}
    });
});</script>';
}

function enableSubmitButton()
{

    echo '<script > $("#newPassword").on("input", function(e){
        $("#submit").prop("disabled", false);
       });
       $("#confirmPassword").on("input", function(e){
        $("#submit").prop("disabled", false);
       });
       
       
       </script>';

}

?>