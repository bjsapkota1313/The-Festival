<?php
require __DIR__ . '/../../Services/userService.php';

class ManageUsersController
{
    private $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function searchUsers(): void
    {
        try {
            $this->sendHeaders();
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $users = null;
                if (empty($_GET['SearchTerm'])) {
                    if (empty($_GET['sortSelectedOption'])) {
                        $users = $this->userService->getAllUsers();
                    } else {
                        $sortSelectedOption = htmlspecialchars($_GET['sortSelectedOption']);
                        $users = $this->getUsersBySortingOptionSelected($sortSelectedOption);
                    }
                } else {
                    $searchingTerm = htmlspecialchars($_GET['SearchTerm']);
                    if (!empty($_GET['sortSelectedOption'])) {
                        $sortSelectedOption = htmlspecialchars($_GET['sortSelectedOption']);
                        $users = $this->userService->getUsersBySearchAndSpecificRoles($searchingTerm, Roles::fromString($sortSelectedOption));
                    } else {
                        $users = $this->userService->getUsersBySearchQuery($searchingTerm);
                    }
                }
                echo JSon_encode($users);
            }
        } catch (InvalidArgumentException|Exception $e) {
            http_response_code(500); // sending bad request error to APi request if something goes wrong
            echo $e->getMessage();
        }
    }

    public function deleteUser(): void
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->sendHeaders();
                $responseData = "";
                $users = null;
                $body = file_get_contents('php://input');
                $data = json_decode($body);
                $checkDeleted = $this->userService->deleteUserById(htmlspecialchars($data->userID));
                if ($checkDeleted) {
                    $sortingOption = htmlspecialchars($data->SortingCondition);
                    $users = $this->getUsersBySortingOptionSelected($sortingOption); // sending data as it is in ui
                    $responseData = array(
                        "Success" => true,
                        "users" => json_encode($users)
                    );
                }
            } else {
                $responseData = array(
                    "Success" => false,
                    "Message" => "Sorry, Something went wrong while deleting user"
                );
            }
            echo json_encode($responseData);
        } catch (InvalidArgumentException|PDOException|Exception $e) {
            http_response_code(500); // sending bad request error to APi request if something goes wrong
            echo $e->getMessage();
        }
    }


    public function sortUsers(): void
    {
        try {
            $this->sendHeaders();
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $users = null;
                if (empty($_GET['selectedOption'])) {
                    $users = $this->userService->getAllUsers();
                } else {
                    $sortBy = htmlspecialchars($_GET['selectedOption']);
                    $users = $this->getUsersBySortingOptionSelected($sortBy);
                }
            }
            echo JSon_encode($users);
        } catch (InvalidArgumentException|Exception $e) {
            http_response_code(500); // sending bad request error to APi request if something goes wrong
            echo $e->getMessage();
        }
    }

    private function sendHeaders(): void
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header("Access-Control-Allow-Methods: *");
        header('Content-Type: application/json');
    }

    private function getUsersBySortingOptionSelected($selectedOption): ?array
    {
        $users = null;
        switch ($selectedOption) {
            case "A-z":
                $users = $this->userService->getUserBySortingFirstNameByAscendingOrder();
                break;
            case "Z-A":
                $users = $this->userService->getUserBySortingFirstNameByDescendingOrder();
                break;
            case in_array($selectedOption, Roles::getEnumValues()): // makings enums dependent with class
                $users = $this->userService->getUsersByRoles(Roles::fromString($selectedOption));
                break;
            case "All Users":
                $users = $this->userService->getAllUsers();
                break;
        }
        return $users;
    }

//TODO: 1. Add Request Handler for edit user details
    public function editUserDetails()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->sendHeaders();
            $userDetails = json_decode($_POST['details']);
            $profilePicture = $_FILES['profilePicture'];
            $userID = htmlspecialchars($userDetails->id);
            $userFirstName = htmlspecialchars($userDetails->firstName);
            $userLastName = htmlspecialchars($userDetails->lastName);
            $userEmail = htmlspecialchars($userDetails->email);
            $userDateOfBirth = htmlspecialchars($userDetails->dateOfBirth);
            $userRole = htmlspecialchars($userDetails->role);
            $userPassword = ""; // setting up the default value

            if (!empty($userDetails->password)) {
                $userPassword = htmlspecialchars($userDetails->password);
            }
            $updatingUser = $this->createUserInstance($userID, $userFirstName, $userLastName, $userEmail, $userDateOfBirth, $userRole, $userPassword);
            $success = $this->userService->updateUserV2($updatingUser, $profilePicture);
        }


    }

    private function createUserInstance($id, $firstName, $lastName, $email, $dateOfBirth, $role, $password)
    {
        try {
            $user = new User();
            $user->setId($id);
            $user->setFirstName($firstName);
            $user->setLastName($lastName);
            $user->setEmail($email);
            $user->setDateOfBirth(new DateTime($dateOfBirth));
            $user->setRole(Roles::fromString($role));
            $user->setHashedPassword($password);

            return $user;
        } catch (InvalidArgumentException|Exception $e) { // whenever something goes wrong while parsing
            http_response_code(500); // sending bad request error to APi request if something goes wrong
        }

    }
}