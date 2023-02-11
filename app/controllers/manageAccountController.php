<?php
require '../services/userService.php';

class ManageAccountController
{
    private $userService;

    function __construct()
    {
        $this->userService = new UserService();
    }

    public function index()
    {
        //$model = $this->userService->getAllUsers();
        require __DIR__ . '/../views/manageAccount/index.php';

    }
}

?>