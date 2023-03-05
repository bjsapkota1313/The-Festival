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
    $('#password-fields').slideToggle('slow');
    });</script>";

}

function submitAccountInfo()
{

    echo '<script > 
    $(function(){
        $("#submit").on("click", function(){   
    var newPasword = $("#newPassword").val();
    var confirmPassword = $("#confirmPassword").val();
    if(newPassword !== confirmPassword){
    $("#validationMessage").text("Passwords Do Not Match!");  
        $("#submit").prop("disabled", true);}
        
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
