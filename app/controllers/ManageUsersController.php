<?php
require_once __DIR__ . '/controller.php';
require_once __DIR__ . '/../models/user.php';
require_once __DIR__ . '/../Services/userService.php';

class ManageUsersController extends Controller
{
    private $userService;

    public function __construct()
    {
        $this->checkLoggedInUserIsAdminstrator(); // checking if the logged user or not show that this page can be logged in if the user is not logged in or
        // if the user is not an administrator, it will redirect to the not allowed page.
        $this->userService = new UserService();
    }

    public function index()
    {
        $users = $this->userService->getAllUsers();
        require __DIR__ . '/../views/ManageUsers/OverviewManageUsers.php';
    }
    private function checkLoggedInUserIsAdminstrator(): void
    {
        if (isset($_SESSION["loggedUser"])) {
            if (unserialize(serialize($_SESSION["loggedUser"]))->getRole() == Roles::Administrator()) {

            } else {
                $this->displayPageView("NotAllowedPage");
                exit(); // exit the controller if user is not admin
            }
        } else {
            header("location: /login");
            exit();
        }
    }
    public function editUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['btnEditUser']) && isset($_POST['hiddenUserId'])) {
            $userId = $this->sanitizeInput($_POST['hiddenUserId']);
            $editingUser = $this->userService->getUserById($userId);
            if (!is_null($editingUser)) {
                require __DIR__ . '/../views/ManageUsers/EditUser.php';
            } else {
                echo "User is not found";
            }
        } else {
            http_response_code(401); // Unauthorised Request
            exit();
        }
    }

    public function registerNewUser()
    {
        $message = $this->registerNewUserSubmit();
        require __DIR__ . '/../views/ManageUsers/RegisterNewUser.php';
    }


    private function registerNewUserSubmit()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['btnRegister'])) {// initialize message variable
            if (!empty($_POST['firstName']) && !empty($_POST['lastName']) && !empty($_POST['email']) && !empty($_POST['dateOfBirth']) && !empty($_POST['role']) && !empty($_POST['password']) && !empty($_POST['passwordConfirm'])) {
                $dateParseResult=$this->parseDateOfBirth($this->sanitizeInput($_POST['dateOfBirth']));
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
                            echo "<script>location.href='/manageusers'</script>";
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