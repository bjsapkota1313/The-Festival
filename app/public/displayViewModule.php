<?
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
    var newPassword = $("#newPassword").val();
    var confirmPassword = $("#confirmPassword").val();
    if(newPassword !== confirmPassword){
    $("#validationMessage").text("Passwords Do Not Match!");
        $("#submit").prop("disabled", true);
        event.preventDefault();
    
    }    
    else {
        event.currentTarget.submit();   
        document.getElementById("#updateForm").reset();       
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
