<?php
if (!isset($_SESSION)) {
    session_start();
}
//error_reporting(E_ALL | E_WARNING);

include("../config/dbconfig.php");
require_once '../services/userService.php';


try {
    $connection = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>

<?php
include __DIR__ . '/../header.php';

$GLOBALS["currentUserId"] = unserialize(serialize($_SESSION["loggedUser"]))->getId();

$GLOBALS['userService'] = new UserService();
$currentUser = $GLOBALS['userService']->getUserById($GLOBALS['currentUserId']);



function DisplayPage($currentUser)
{
    if ($currentUser->getRole() == Roles::Customer()) {
        echo $currentUser->getId();
        echo '<script >document.getElementById("userRole").style.display = "none";</script>';

        ?>

    <?php
    }
}

function getInputBirthDate()
{

    $dateInput = strtotime($_POST['dateOfBirth']);
    if ($dateInput) {
        $dateOfBirth = date('Y-m-d', $dateInput);
        return $dateOfBirth;
    }

}

function updateProfile($connection, $currentUserId)
{

    if (isset($_POST["updateProfile"])) {
        echo 'Update';
        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];
        if (isset($_POST["userRole"])) {
            $role = $_POST["userRole"];
        } else {
            $role = 'Customer';
        }
        $email = $_POST["email"];
        $birthDate = getInputBirthDate();

        move_uploaded_file($_FILES["file"]["tmp_name"], "./img/" . $_FILES["file"]["name"]);
        $path = "./img/" . $_FILES["file"]["name"];
        $GLOBALS["userService"]->updateUser($connection, $currentUserId, $role, $firstName, $lastName, $birthDate, $email, $path);
        echo '<h5>Your profile was updated</h5><br>';

    }

}

echo '<main>';

echo '<div class="container d-flex justify-content-center align-items-center pt-5">
<div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
        <div class="card shadow-sm">
            <div class="card-body">
                <h1 class="card-title text-center mb-4">' . $currentUser->getFirstName() . ' ' . $currentUser->getLastName() . '</h2><br>
                <form method="POST" enctype="multipart/form-data">
                    <div class="row mb-3">
                            <div class="profile-img-container mb-3">
                              <img src="' . $currentUser->getPicture() . '"alt="Profile Picture" class="img-fluid">
                              <div class="mb-3">
                              <br><br>
                              <label>Change your picture:</label>
                                <input type="file" name="file" id="file"><br><br>
                                </div>

                        </div>
                        <div class="col-md-8">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                        <label for="first-name" class="form-label">First Name</label>
                                        <input type="text" class="form-control" name="firstName" value="' . $currentUser->getFirstName() . '" required>
                                    </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="last-name" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" name="lastName" value="' . $currentUser->getLastName() . '" required>
                                    </div>
                                </div>
                            </div>';


echo ' <div class="row mb-3" id="userRole">
                                <div class="col-md-6">';
DisplayPage($currentUser);
echo
    '<div class="mb-3">
                                    <select name="userRole" >
                                    <option value="none" selected disabled hidden>' . 'customer' . '</option>
                                    <option value="Customer">Customer</option>
                                    <option value="Administrator">Administrator</option>
                                    <option value="Employee">Employee</option>
                                  </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" value="' . $currentUser->getEmail() . '" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="dob" class="form-label">Date of Birth</label>
                                        <input type="date" name= "dateOfBirth" class="form-control" value="' . $currentUser->getDateOfBirth()->format('Y-m-d') . '"required>
                                    </div>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="col-md-6">
                                    <div class="d-grid gap-2">
                                        <button type="submit" name="updateProfile" class="btn btn-primary btn-lg" >Save Changes</button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-grid gap-2">
                                        <button type="reset" class="btn btn-secondary btn-lg">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>';

UpdateProfile($connection, $GLOBALS['currentUserId']);
echo '</main';

include __DIR__ . '/../footer.php';
?>