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
        $model = $this->userService->getAll();

        require '../views/manageAccount/index.php';
    }
}

?>