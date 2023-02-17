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
            if (unserialize(serialize($_SESSION["loggedUser"]->getRole())) == Roles::Administrator()) {
                $users = $this->userService->getAllUsers();
                if (!is_null($users)) {
//                 $this->displayPageView("OverviewMangeUsers",$users);
                    require __DIR__ . '/../views/ManageUsers/OverviewManageUsers.php';
                } else {
                    echo "No users are In the Website";
                }
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
                require __DIR__ . '/../views/ManageUsers/EditIndividualUser.php';
            } else {
                echo "User is not found";
            }
        } else {
            http_response_code(401); // Unauthorised Request
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