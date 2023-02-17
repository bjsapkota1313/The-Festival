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
        // check if the user is already logged in.
        // if $_SESSION["loggedUser"] is set, it means the user has already logged in.
        // if the user is already logged in, redirect her to /home.
        if (isset($_SESSION["loggedUser"])) {
            // echo "you are already logged in";
            header("location: /home");
            exit();
        }
        // if the user has submitted a login request,
        // the form calls login again, but this time, the $_POST parameters
        // are set. So, we enter the else if.
        else if(isset($_POST["signInSubmit"]) && isset($_POST["username"]) && isset($_POST["pwd"])) {
            $inputUserName = $_POST["username"];
            $inputPassword = $_POST["pwd"];
            // using html special chars function to clean up the input
            $inputUserName = htmlspecialchars($inputUserName);
            $inputPassword = htmlspecialchars($inputPassword);
            // checkLogin method in UserService class checks if the user with the given username and password exists in the database. If it exits, it returns the user object, if it does not exists or the password is wrong, it returns null.
            $user = $this->userService->checkLogin($inputUserName, $inputPassword);
            if (isset($user) && $user != null ) {
                // if the user exists in the database, log it in.
                // to show the user is logged in, we set the loggeUser value in $_SESSION dictionary. Then, we redirect to home.
                $_SESSION['loggedUser']=$user;
                header("location: /home");
            }
            // if the username or password is wrong, we are here
            else {
                // displayView shows the contents of views/login/index.php
                $this->displayView("Wrong Credentials. Try again.");
            }
        } 
        // if the user is visiting the login page normally, show her the login page!
        else {
            // displayView shows the contents of views/login/index.php
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