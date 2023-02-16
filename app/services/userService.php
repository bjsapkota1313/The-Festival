<?php
require_once __DIR__ . '/../repositories/userRepository.php';
require_once __DIR__ . '/../models/user.php';
require_once __DIR__ . '/../PHPMailer/Exception.php';
require_once __DIR__ . '/../PHPMailer/SMTP.php';
require_once __DIR__ . '/../PHPMailer/PHPMailer.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class UserService
{
    // public function setReviewId(int $reviewId): self
    public function checkLogin(string $userName, string $password)
    {
        $repository = new UserRepository();
        $user = $repository->login($userName, $password);
        if (isset($user) && $user != null) {
            return $user;
        }
        return null;
    }

    public function getUserById(int $userId)
    {
        $repository = new UserRepository();
        return $repository->getUserById($userId);
    }
    public function getAllUsers()  {
        $repository = new UserRepository();
        return $repository->getAllUsers();
    }
    public function getUsersBySearchQuery($searchingTerm){
        $repository = new UserRepository();
        return $repository->getUsersBySearchQuery($searchingTerm);
    }
    public function getUserBySortingFirstNameByAscOrDescOrders($order)
    {
        $repository = new UserRepository();
        return $repository->getUserBySortingFirstNameByAscOrDescOrders($order);
    }
    public function getUserBySortingFirstNameByAscendingOrder(){
         return $this->getUserBySortingFirstNameByAscOrDescOrders("ASC");
    }
    public function getUserBySortingFirstNameByDescendingOrder(){
       return  $this->getUserBySortingFirstNameByAscOrDescOrders("DESC");
    }
    public function getUsersByRoles($roles){
        $repository = new UserRepository();
        return $repository->getUsersByRoles($roles);
    }
    public function getUsersBySearchAndSpecificRoles($searchingTerm, $criteria){
        $repository = new UserRepository();
        return $repository->getUsersBySearchAndSpecificRoles($searchingTerm, $criteria);
    }
    public function deleteUserById($userId) :bool{
        $repository = new UserRepository();
        return $repository->deleteUserById($userId);
    }
    public function registerUser($newUser): void
    {
        $repository = new UserRepository();
        $plainPassword=$newUser['password'];
        $newUser['password']=$this->hashPassword($plainPassword);
        $repository->registerUser($newUser);
    }

    public function checkUserExistenceByEmail($email)
    {
        $repository = new UserRepository();
        return $repository->checkUserExistenceByEmail($email);
    }

    public function putRandomTokenForNewPassword($token, $expiration_time,$email): void
    {
        $repository = new UserRepository();
        $repository->putRandomTokenForNewPassword($token, $expiration_time,$email);
    }

    public function updatePassword($email, $newPassword): void
    {
        $repository = new UserRepository();
        if($repository->updatePassword($email, $this->hashPassword($newPassword))){
            date_default_timezone_set('Europe/Amsterdam');
            $tokenExpiration = date('Y-m-d H:i:s');

            $this->deleteDataForgotPassword($email,$tokenExpiration);
        }
    }
    public function deleteDataForgotPassword($email,$tokenExpiration): void
    {
        $repository = new UserRepository();
        $repository->deleteDataForgotPassword($email, $tokenExpiration);
    }
    /**
     * @throws Exception
     */
    public function sendEmail($email): void
    {
        $token = bin2hex(random_bytes(16));
        date_default_timezone_set('Europe/Amsterdam');
        $expiration_time = date('Y-m-d H:i:s', time() + (60 * 20));

        $mail = new PHPMailer(true);

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'thefestivalinholland@gmail.com';                 // SMTP username
        $mail->Password = 'wwfixdhlyjwhjruh';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        $mail->setFrom('thefestivalinholland@gmail.com', 'The Festival Team');
        $mail->addAddress($email);     // Add a recipient

        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = 'Verification Code';
//        $mail->Body = 'This is Verification code for changing password ' . $token .' Do not share it!';
        $mail->Body = 'http://localhost/login/updatePassword?token=' . $token;;

        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent';
            $passwordResetLink =
            $this->putRandomTokenForNewPassword($token,$expiration_time,$email);
        }
    }
    public function isTokenValid($token){
        $repository = new UserRepository();
        return $repository->isTokenValid($token);
    }
    public function hashPassword($password)
    {
        try {
             return password_hash($password ,PASSWORD_DEFAULT);
        } catch (Exception $exception) {
            echo $exception->getMessage();
        }
    }
}
