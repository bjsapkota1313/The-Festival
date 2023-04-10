<?php
require_once __DIR__ . '/AdminPanelController.php';
require_once __DIR__ . '/../../Services/userService.php';
require_once __DIR__ . '/../../models/User.php';

class AdminManageUsersController extends AdminPanelController
{
    private $userService;

    public function __construct()
    {
        parent::__construct();
        $this->userService = new UserService();
    }

    public function index()
    {
        $users = $this->userService->getAllUsers();
        $this->displaySideBar("User Management");
        require __DIR__ . '/../../views/AdminPanel/ManageUsers/OverviewManageUsers.php';
    }
    public function editUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['btnEditUser']) && isset($_POST['hiddenUserId'])) {
            $userId = $this->sanitizeInput($_POST['hiddenUserId']);
            $editingUser = $this->userService->getUserById($userId);
            if (!is_null($editingUser)) {
                $this->displaySideBar("Edit User",'/css/registerStyle.css');
                require __DIR__ . '/../../views/AdminPanel/ManageUsers/EditUser.php';
            } else {
                $this->display404PageNotFound();
            }
        } else {
            http_response_code(401); // Unauthorised Request
            exit();
        }
    }

    public function registerNewUser()
    {
        $message = $this->registerNewUserSubmit();
        $this->displaySideBar("RegisterNewUser",'/css/registerStyle.css');
        require __DIR__ . '/../../views/AdminPanel/ManageUsers/RegisterNewUser.php';
    }


    private function registerNewUserSubmit()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['btnRegister'])) {// initialize message variable
            if (!empty($_POST['firstName']) && !empty($_POST['lastName']) && !empty($_POST['email']) && !empty($_POST['dateOfBirth']) && !empty($_POST['role']) && !empty($_POST['password']) && !empty($_POST['passwordConfirm'])) {
                $dateParseResult=$this->parseDateOfBirth($this->sanitizeInput($_POST['dateOfBirth'])); //TODO: check if the date is valid
                if(is_string($dateParseResult)){ // checking if the controller sends some error message or not
                    return $dateParseResult;
                }
                $password = $this->sanitizeInput($_POST['password']);
                $passwordConfirm = $this->sanitizeInput($_POST['passwordConfirm']);
                if ($this->userService->checkUserExistenceByEmail($this->sanitizeInput($_POST['email']))) {
                    return "User with this email already exists";
                } else {
                    if ($password == $passwordConfirm) {
                        $user = array(
                            "firstName" => $this->sanitizeInput($_POST["firstName"]),
                            "lastName" => $this->sanitizeInput($_POST["lastName"]),
                            "dateOfBirth" => $this->sanitizeInput($_POST["dateOfBirth"]),
                            "email" => $this->sanitizeInput($_POST["email"]),
                            "password" => $this->sanitizeInput($_POST["password"]),
                            "role" => Roles::fromString($_POST["role"]),
                            "picture" => $_FILES['profilePicUpload']
                        );
                        if ($this->userService->registerUser($user)) {
                            header("Location: /admin/manageusers");
                            exit();
                        } else {
                            return "Something went wrong while creating an account please try again later";
                        }

                    } else {
                       return "Password and Confirm Password does not match";
                    }
                }

            } else {
                return "Please, fill every field in order create an account";
            }
        }
    }


}