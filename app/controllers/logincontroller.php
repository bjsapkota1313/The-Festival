<?php
require __DIR__ . '/controller.php';
require __DIR__ . '/../services/userService.php';
require_once __DIR__ . '/../models/user.php';

class LoginController extends Controller {
    private $userService;
    // initialize services
    function __construct() {
        $this->userService = new UserService();
    }
    public function test() {
        echo "This is a test for login page";
    }
    public function passhash() {
        $pass = "Test";
        echo password_hash($pass, PASSWORD_DEFAULT);
    }
    public function index($query)
    {
        if(isset($_SESSION["username"])) {
            header("location: /home");
            exit();
        }

        if(isset($_POST["signInSubmit"]) && isset($_POST["username"]) && isset($_POST["pwd"])) {
            $inputUserName = $_POST["username"];
            $inputPassword = $_POST["pwd"];
            // using html special chars function to clean up the input
            $inputUserName = htmlspecialchars($inputUserName);
            $inputPassword = htmlspecialchars($inputPassword);
            $user = $this->userService->checkLogin($inputUserName, $inputPassword);
            if (isset($user) && $user != null ) {
                $_SESSION["email"] = $user->getEmail();
                $_SESSION["randomSeed"] = bin2hex(random_bytes(32));
                if($user instanceof User) {
                    $_SESSION["userRole"] = $user->getRole();
                    $_SESSION["id"] = $user->getId();
                    // $this->displayView("Welcome Reader: " . $user->getFirstName());
                }
                header("location: /home");
                // echo "successfully logged in";
            }
            else {
                $this->displayView("Wrong Credentials. Try again.");
            }
        }
        else {
            $this->displayView(null);
        }
    }
}