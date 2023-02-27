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
        $this->currentUserId = unserialize(serialize($_SESSION["loggedUser"]))->getId();
        $this->currentUser = $this->userService->getUserById($this->currentUserId);
    }

    public function index()
    {   
        $currentUser = $this->currentUser;
        $this->test();

    }


    function getInputBirthDate()
{
    $dateInput = strtotime($_POST['dateOfBirth']);
    if ($dateInput) {
        $dateOfBirth = date('Y-m-d', $dateInput);
        return $dateOfBirth;
    }
}

  public  function updateProfile($currentUserId)
{
    $validationMessage = "";
    if (isset($_POST["updateProfile"])) {
        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];
        if (isset($_POST["userRole"])) {
            $role = $_POST["userRole"];
        } else {
            $role = 'Customer';
        }
        $email = $_POST["email"];
        $birthDate = $this->getInputBirthDate();
        move_uploaded_file($_FILES["file"]["tmp_name"], "./image/" . $_FILES["file"]["name"]);
        $path = "./image/" . $_FILES["file"]["name"];
        $password = $_POST["newPassword"];
        $confirmedPassword = $_POST["confirmPassword"];
      
        if ($password == $confirmedPassword){
        $this->userService->updateUserProfile($currentUserId, $role, $firstName, $lastName, $birthDate, $email, $path, $password);
    
        }
        else {

            $validationMessage = "The current passwords don't match.";
        }
    }
    require __DIR__ . '/../views/manageAccount/index.php';

}

    public function test(){
        $userId = $this->currentUserId;
        $this->updateProfile($userId);

    }
}

?>