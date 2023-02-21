<?
function DisplayPage($currentUser)
{
    if ($currentUser->getRole() == Roles::Customer()) {
        echo '<script >document.getElementById("manageUsersLink").style.display = "none";</script>';
    }
}

?>