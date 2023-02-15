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
        try{
            if($_SERVER['REQUEST_METHOD']==='POST'){
                $this->sendHeaders();
                $responseData="";
                $users=null;
                $body = file_get_contents('php://input');
                $data = json_decode($body);
                $checkDeleted=$this->userService->deleteUserById(htmlspecialchars($data->userID));
                if($checkDeleted){
                    if(empty($body->SortingCondition)){
                        $users=$this->userService->getAllUsers();
                        $responseData=array(
                            "Success" => true,
                            "users"=>json_encode($users)
                        );
                    }
                    else{
                        $sortingOption =htmlspecialchars($body->SortingCondition);
                        if(in_array($sortingOption, Roles::getEnumValues())){
                            $responseData=array(
                                "Success" => true,
                                "users"=>json_encode($users)
                            );
                        }
                        else{
                            throw new InvalidArgumentException("Cannot Parse the values");
                        }
                    }
                }
                else{
                    $responseData=array(
                        "Success" => true,
                        "Message"=>"Sorry, Something went wrong while deleting user"
                    );
                }
                echo json_encode($responseData);
            }
        }
        catch(InvalidArgumentException | PDOException | Exception $e){
            http_response_code(500); // sending bad request error to APi request if something goes wrong
            echo $e->getMessage();
        }
    }

    public function sortUsers(): void
    {
        try {
            $this->sendHeaders();
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {$users = null;
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
}