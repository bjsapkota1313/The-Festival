<?


function DisplayManageAccountPage($currentUser)
{
    if ($currentUser->getRole() == Roles::Customer()) {
        echo $currentUser->getId();
        echo '<script >document.getElementById("userRole").style.display = "none";</script>';
    }
}


?>
