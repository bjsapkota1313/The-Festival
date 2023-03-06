<?php

function DisplayManageAccountPage($currentUser)
{
    if ($currentUser->getRole() == Roles::Customer()) {
        echo '<script >document.getElementById("userRole").style.display = "none";</script>';
    }
}

?>
