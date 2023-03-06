<?php
require '../services/userService.php';


class ManageAccountController
{
    private $userService;
    private $currentUser;
    private $currentUserId;

    private $updated;

    function __construct()
    {
        $this->userService = new UserService();
        $this->currentUserId = unserialize(serialize(current($_SESSION["loggedUser"])));
        $this->currentUser = $this->userService->getUserById($this->currentUserId);
    }

    public function index()
    {   
        $currentUser = $this->currentUser;
        $this->updateAccountData();

    }


    function getInputBirthDate()
{
    $dateInput = strtotime($_POST['dateOfBirth']);
    if ($dateInput) {
        $dateOfBirth = date('Y-m-d', $dateInput);
        return $dateOfBirth;
    }
}

function  setProfileImagePath(){

    $newPicture = $_FILES["file"]["name"];
    $imagePath = "";
    if ($newPicture != ""){
    move_uploaded_file($_FILES["file"]["tmp_name"], "./image/" . $newPicture );
    $imagePath = "./image/" . $newPicture;}
    else {
        $initialPicture  = $this->currentUser->getPicture();

        $imagePath =  $initialPicture;
    }

    return $imagePath;

}


function setUserPassword(){

    $updatedProfile = false;
    $password = $_POST["newPassword"];
    $confirmedPassword = $_POST["confirmPassword"];

    if ($password == $confirmedPassword){
        $this->userService->updatePasswordFromAccount($this->currentUserId, $password);
        $updatedProfile = true;
    }

    require_once __DIR__ . '/../views/manageAccount/index.php';

    return $updatedProfile;
}

  public  function updateProfile($currentUserId)
{
   

    if (isset($_POST["updateProfile"])) {

        $validationMessage = "";
        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];
        if (isset($_POST["userRole"])) {
            $role = $_POST["userRole"];
        } else {
            $role = 'Customer';
        }
        $email = $_POST["email"];
        $birthDate = $this->getInputBirthDate();
        $imagePath = $this->setProfileImagePath();
        
        if(!empty($_POST['newPassword']) || !empty($_POST['confirmPassword'])){
         $updatedProfile = $this->setUserPassword();
         if($updatedProfile){
            $this->userService->updateUserProfile($currentUserId, $role, $firstName, $lastName, $birthDate, $email, $imagePath);
        }echo 'case1';
        }
        else {
            $this->userService->updateUserProfile($currentUserId, $role, $firstName, $lastName, $birthDate, $email, $imagePath);
            echo 'case2';
        }
    }
    require_once __DIR__ . '/../views/manageAccount/index.php';

}

    public function updateAccountData(){
        $userId = $this->currentUserId;
        $this->updateProfile($userId);

    }
}
