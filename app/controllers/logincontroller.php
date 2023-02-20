<?php
require __DIR__ . '/controller.php';
require __DIR__ . '/../services/userService.php';
require_once __DIR__ . '/../models/user.php';

class LoginController extends Controller
{
    private $userService;

    // initialize services
    function __construct()
    {
        $this->userService = new UserService();
    }

    public function test()
    {
        echo "This is a test for login page";
    }

    public function passhash()
    {
        $pass = "Test";
        echo password_hash($pass, PASSWORD_DEFAULT);
    }

    public function index($query)
    {
        if (isset($_SESSION["loggedUser"])) {
            header("location: /home");
            exit();
        }
        if (isset($_POST["signInSubmit"]) && isset($_POST["username"]) && isset($_POST["pwd"])) {
            $inputUserName = $_POST["username"];
            $inputPassword = $_POST["pwd"];
            // using html special chars function to clean up the input
            $inputUserName = htmlspecialchars($inputUserName);
            $inputPassword = htmlspecialchars($inputPassword);
            $user = $this->userService->checkLogin($inputUserName, $inputPassword);
            if (isset($user) && $user != null) {

                if ($user instanceof User) {
                    $_SESSION['loggedUser'] = $user;
                }
                header("location: /home");
            } else {
                $this->displayView("Wrong Credentials. Try again.");
            }
        } else {
            $this->displayView(null);
        }
    }

    public function registerUser()
    {
        if (isset($_POST["registerBtn"])) {
            $secret = "6LelT5MkAAAAAP3xY6DkyRryMLG9Wxe2Xt48gz7t";
            $response = $_POST['g-recaptcha-response'];
            $remoteip = $_SERVER['REMOTE_ADDR'];
            $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$remoteip";
            $data = file_get_contents($url);
            $row = json_decode($data, true);
            if ($row['success'] == "true") {
                if ($this->userService->checkUserExistenceByEmail(htmlspecialchars($_POST["email"]))) {
                    echo "<script>alert('duplicated email')</script>";
                }
                else if ($_POST['password'] != $_POST['passwordConfirm']) {
                        echo "<script>alert('password wrong')</script>";
                    } else {
                        $newUser = array(
                            "firstName" => htmlspecialchars($_POST["firstName"]),
                            "lastName" => htmlspecialchars($_POST["lastName"]),
                            "dateOfBirth" => htmlspecialchars($_POST["dateOfBirth"]),
                            "email" => htmlspecialchars($_POST["email"]),
                            "password" => htmlspecialchars($_POST["password"]),
                            "picture" => $_FILES['createUserImage'],
                            "role" => Roles::customer()
                        );
                        $this->userService->registerUser($newUser);
                        echo "<script>alert('you are not a robot');</script>";
                    }
                }
            else{
                    echo "<script>alert('you are a robot');</script>";
                }
            }
        require __DIR__ . '/../views/login/register.php';
    }

    /**
     * @throws Exception
     */
    public function resetPasswordViaEmail()
    {
        if (isset($_POST["send-link"])) {
            $email = htmlspecialchars($_POST["forgotPasswordEmail"]);
            if ($this->userService->checkUserExistenceByEmail($email)) {
                $this->userService->sendEmail($email);
            } else {
                echo "<script>alert('We cannot find this email from our system')</script>";
            }
        }
        require __DIR__ . '/../views/login/sendEmailForgotPassword.php';
    }

    public function updatePassword()
    {
        if (isset($_POST["updatePassword"])) {
            $token = $_GET["token"];
            if ($this->userService->isTokenValid($token)) {

                $newPassword = $_POST['updateNewPassword1'];
                $userId = $this->userService->isTokenValid($token);

                $this->userService->updatePassword($userId, $newPassword);
            }
        }
        require __DIR__ . '/../views/login/updateForgotPassword.php';
    }
}