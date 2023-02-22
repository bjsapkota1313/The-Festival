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
        if ($this->checkLoggedInUserIsAdminstrator()) {
            $users = $this->userService->getAllUsers();
            require __DIR__ . '/../views/ManageUsers/OverviewManageUsers.php';
        }
    }

    private function checkLoggedInUserIsAdminstrator()
    {
        if (isset($_SESSION["loggedUser"])) {
            if (unserialize(serialize($_SESSION["loggedUser"]))->getRole() == Roles::Administrator()) {
                return true;
            } else {
                $this->displayPageView("NotAllowedPage");
                return false;
            }
        } else {
            header("location: /login");
            exit();
        }
    }

    public function editUser()
    {
        if ($this->checkLoggedInUserIsAdminstrator()) {
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
                exit();
            }
        }

    }

    public function registerNewUser()
    {
        if ($this->checkLoggedInUserIsAdminstrator()) {
            $message = $this->registerNewUserSubmit();
            require __DIR__ . '/../views/ManageUsers/RegisterNewUser.php';
        }
    }


    private function registerNewUserSubmit()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['btnRegister'])) {
            $message = null; // initialize message variable
            if (isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['email']) && isset($_POST['dateOfBirth']) && isset($_POST['role']) && isset($_POST['password']) && isset($_POST['passwordConfirm'])) {
                try {
                    $dateOfBirth = htmlspecialchars($_POST['dateOfBirth']);
                } catch (Exception $e) {
                    $message = "Please enter a valid date";
                    return;
                }
                $password = htmlspecialchars($_POST['password']);
                $passwordConfirm = htmlspecialchars($_POST['passwordConfirm']);
                if ($this->userService->checkUserExistenceByEmail(htmlspecialchars($_POST['email']))) {
                    $message = "User with this email already exists";
                } else {
                    if ($password == $passwordConfirm) {
                        $user = array(
                            "firstName" => htmlspecialchars($_POST["firstName"]),
                            "lastName" => htmlspecialchars($_POST["lastName"]),
                            "dateOfBirth" => htmlspecialchars($_POST["dateOfBirth"]),
                            "email" => htmlspecialchars($_POST["email"]),
                            "password" => htmlspecialchars($_POST["password"]),
                            "role" => Roles::fromString($_POST["role"]),
                            "picture" => $_FILES['profilePicUpload']
                        );
                        if ($this->userService->registerUser($user)) {
                            echo "<script>location.href='/manageusers'</script>";
                            exit();
                        } else {
                            $message = "Something went wrong while creating an account please try again later";
                        }

                    } else {
                        $message = "Password and Confirm Password does not match";
                    }
                }

            } else {
                $message = "Please, Dont leave any field empty";
            }
            return $message;
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