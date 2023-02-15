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
        if (isset($_SESSION["username"])) {
            header("location: /home");
            exit();
        }
        if (isset($_POST["signInSubmit"]) && isset($_POST["username"]) && isset($_POST["pwd"])) {
            $user = $this->userService->checkLogin($_POST["username"], $_POST["pwd"]);
            if (isset($user) && $user != null) {
                $_SESSION["email"] = $user->getEmail();
                $_SESSION["randomSeed"] = bin2hex(random_bytes(32));
                if ($user instanceof User) {
                    $_SESSION["userRole"] = $user->getRole();
                    $_SESSION["id"] = $user->getId();
                    // $this->displayView("Welcome Reader: " . $user->getFirstName());
                }
                header("location: /home");
                // echo "successfully logged in";
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
            if ($this->userService->checkUserExistenceByEmail(htmlspecialchars($_POST["email"]))) {
                echo "<script>alert('duplicated email')</script>";
            } else if ($_POST['password'] != $_POST['passwordConfirm']) {
                echo "<script>alert('password wrong')</script>";
            } else {
                $file = $_FILES['createUserImage'];
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $newImageName = uniqid() . '.' . $ext;
                $upload_dir = __DIR__ . '/../public/image/';
                $success = move_uploaded_file($file['tmp_name'], $upload_dir . $newImageName);
                if ($success) {
                    $newUser = array(
                        "firstName" => htmlspecialchars($_POST["firstName"]),
                        "lastName" => htmlspecialchars($_POST["lastName"]),
                        "dateOfBirth" => htmlspecialchars($_POST["dateOfBirth"]),
                        "email" => htmlspecialchars($_POST["email"]),
                        "password" => htmlspecialchars($_POST["password"]),
//                        "password" => password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT),
//                        "password" => $this->userService->hashPassword($_POST['password']),
                        "registrationDate" => htmlspecialchars(date("Y-m-d H:i:s")),
                        "picture" => htmlspecialchars('/image/' . $newImageName)
                    );
                    $this->userService->registerUser($newUser);

                } else {
                    echo "<script>alert('Please Select Model Again')</script>";
                }
            }
        }
        require __DIR__ . '/../views/home/about.php';
    }
    /**
     * @throws Exception
     */
    public function resetPasswordViaEmail()
    {
        if (isset($_POST["send-link"])) {
            if ($this->userService->checkUserExistenceByEmail(htmlspecialchars($_POST["forgotPasswordEmail"]))) {
                $email = $_POST["forgotPasswordEmail"];
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
//                $newPassword = $_POST["updateNewPassword1"];
                $email = $this->userService->isTokenValid($token);

                $this->userService->updatePassword($email, $newPassword);
            }
        }
        require __DIR__ . '/../views/login/updateForgotPassword.php';
    }
}