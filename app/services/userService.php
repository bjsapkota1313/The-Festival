<?php
require_once __DIR__ . '/../repositories/userRepository.php';
require_once __DIR__ . '/../models/user.php';
require __DIR__ . '/../PHPMailer/Exception.php';
require __DIR__ . '/../PHPMailer/SMTP.php';
require __DIR__ . '/../PHPMailer/PHPMailer.php';
require_once __DIR__.'/../models/Exceptions/uploadFileFailedException.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class UserService
{
    private $repository;

    public function __construct(){
        $this->repository = new UserRepository();
    }
    // public function setReviewId(int $reviewId): self
    public function checkLogin(string $userName, string $password)
    {
        $user = $this->repository->login($userName, $password);
        if (isset($user) && $user != null) {
            return $user;
        }
        return null;
    }

    public function getUserById(int $userId)
    {
        return $this->repository->getUserById($userId);
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
        $image = $newUser['picture'];
        $newUser['password']=$this->hashPassword($plainPassword);
        $newUser['picture']=$this->storeImage($image);
        $repository->registerUser($newUser);
    }

    public function checkUserExistenceByEmail($email)
    {
        $repository = new UserRepository();
        return $repository->checkUserExistenceByEmail($email);
    }

    public function updatePassword($userId, $newPassword): void
    {
        $repository = new UserRepository();
        if($repository->updatePassword($userId, $this->hashPassword($newPassword))){
            date_default_timezone_set('Europe/Amsterdam');
            $tokenExpiration = date('Y-m-d H:i:s');

            $this->deleteDataForgotPassword($userId,$tokenExpiration);
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
            $id = $this->checkUserExistenceByEmail($email);

            $this->repository->putRandomTokenForNewPassword($token,$expiration_time,$id);
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


    /**
     * @throws uploadFileFailedException
     */
    public function storeImage($image)
    {
        try {
            $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
            $newImageName = uniqid() . '.' . $ext;
            $upload_dir = __DIR__ . '/../public/img/';
            if(!move_uploaded_file($image['tmp_name'], $upload_dir . $newImageName)){
                throw new uploadFileFailedException();
            }
            return $newImageName;

        } catch (Exception $exception) {
            echo $exception->getMessage();
        }
    }

    public function updateUser($connection, $id, $role, $firstName, $lastName,  $dateOfBirth, $email, $picture)
    {
        $repository = new UserRepository();
        return $repository->updateUser($connection, $id, $role, $firstName, $lastName,  $dateOfBirth, $email, $picture);
    }


}
