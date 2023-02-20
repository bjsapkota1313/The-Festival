<?php

class captchaController
{
    private $userSerivce;

    // initialize services
    function __construct()
    {
        $this->userSerivce = new userService();
    }

    private function sendHeaders(): void
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header("Access-Control-Allow-Methods: *");
        header('Content-Type: application/json');
    }

    public function captcha()
    {
        $recaptcha_secret = "6Ld_TpIkAAAAAHDyo3lqI7_ulJ399Qygpo6Gcfaz";
        $recaptcha_response = $_POST['g-recaptcha-response'];

        $verify_url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response;
        $verify_response = file_get_contents($verify_url);
        $verify_response = json_decode($verify_response);

        if ($verify_response->success) {

        } else {
            // The reCAPTCHA was not successful
        }

    }

    public function registerUser()
    {
        if (isset($_POST["registerBtn"])) {
            $this->sendHeaders();
//            $inputCaptcha = $_POST["registerCaptcha"];
            if ($this->userService->checkUserExistenceByEmail(htmlspecialchars($_POST["email"]))) {
                echo "<script>alert('duplicated email')</script>";
            } else if ($_POST['password'] != $_POST['passwordConfirm']) {
                echo "<script>alert('password wrong')</script>";
            }
            $recaptcha_secret = "6Ld_TpIkAAAAAHDyo3lqI7_ulJ399Qygpo6Gcfaz";
            $recaptcha_response = $_POST['g-recaptcha-response'];

            $verify_url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response;
            $verify_response = file_get_contents($verify_url);
            $verify_response = json_decode($verify_response);

            if ($verify_response->success) {
                $newUser = array(
                    "firstName" => htmlspecialchars($_POST["firstName"]),
                    "lastName" => htmlspecialchars($_POST["lastName"]),
                    "dateOfBirth" => htmlspecialchars($_POST["dateOfBirth"]),
                    "email" => htmlspecialchars($_POST["email"]),
                    "password" => htmlspecialchars($_POST["password"]),
                    "registrationDate" => htmlspecialchars(date("Y-m-d H:i:s")),
                    "picture" => $_FILES['createUserImage']
                );
                $this->userService->registerUser($newUser);
            } else {
                // The reCAPTCHA was not successful
            }
            require __DIR__ . '/../views/login/register.php';
        }
//        else {
//                $url = "https://www.google.com/recaptcha/api/siteverify";
//                $data =[
//                    'secret' =>  "6Ld_TpIkAAAAAHDyo3lqI7_ulJ399Qygpo6Gcfaz",
//                    'response' => $_POST["token"],
//                    'remoteip' => $_SERVER['REMOTE_ADDR']
//                ];


//                } else {
//                    echo "<script>alert('Please Select Model Again')</script>";
//                }


    }

}