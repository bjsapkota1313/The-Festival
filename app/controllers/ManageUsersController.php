<?php
require_once __DIR__ . '/controller.php';
require_once __DIR__ . '/../models/user.php';
require_once __DIR__ . '/../Services/userService.php';

class ManageUsersController extends Controller
{
    private $userService;

    public function __construct()
    {
        $this->userService = new UserService();
        $this->testLoggedUser();
    }

    public function index()
    {
        // checking if user is logged in and if adminstrator is not logged in
        if (isset($_SESSION["loggedUser"])) {
            if (unserialize(serialize($_SESSION["loggedUser"]))->getRole() == Roles::Administrator()) {
                $users = $this->userService->getAllUsers();
               // $this->displayPageView("OverviewManageUsers",$users);
                require __DIR__ . '/../views/ManageUsers/OverviewManageUsers.php';
            } else {
                $this->displayPageView("NotAllowedPage");
            }
        } else {
            header("location: /login"); // user is not logged in but manage to come here
        }

    }
    public function editUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['btnEditUser']) && isset($_POST['hiddenUserId'])) {
            $userId = htmlspecialchars($_POST['hiddenUserId']);
            $editingUser = $this->userService->getUserById($userId);
            if (!is_null($editingUser)) {

                require __DIR__ . '/../views/ManageUsers/EditUser.php';
            } else {
                echo "User is not found";
            }
        } else {
            http_response_code(401); // Unauthorised Request
        }
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $this->editUserDetailsSubmit();
        }

    }
    public function editUserDetailsSubmit()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['btnSaveChanges'])) {
            $message= "";
            if(isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['email']) && isset($_POST['dateOfBirth']) && isset($_POST['role'])){
                $firstName = htmlspecialchars($_POST['firstName']);
                $lastName = htmlspecialchars($_POST['lastName']);
                $email = htmlspecialchars($_POST['email']);
                $dateOfBirth = htmlspecialchars($_POST['dateOfBirth']);
                $role = htmlspecialchars($_POST['role']);
                echo $role;
                echo $dateOfBirth;
                echo $email;
                echo $lastName;
                echo $firstName;


            } else {
                $message = "Please, Dont leave any field empty";
            }
        }
    }
    private function testLoggedUser()
    {
        $Bijay = new User();
        $Bijay->setFirstName("Bijay");
        $Bijay->setLastName("Shrestha");
        $Bijay->setEmail("sapkota@inholland.nl");
        $Bijay->setRole(Roles::Administrator());
        $Bijay->setDateOfBirth(new DateTime("1999-01-01"));
        $Bijay->setRegistrationDate(new DateTime("2021-01-01"));
        $Bijay->setId(999);
        $_SESSION["loggedUser"] = $Bijay;
    }
}