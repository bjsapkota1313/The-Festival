<?php
require __DIR__ . '/controller.php';
require_once __DIR__ .'/../services/NavBarService.php';
class ManageInformationController extends Controller
{
    private $navBarService;

    public function __construct()
    {
        $this->navBarService=new NavBarService();
    }

    public function index()
    {
        $this->displayPageView('ManageInformationOverview');
    }
    public function editNav(){
        $navBarItems=$this->navBarService->getAllNavBarItems();
        require_once __DIR__.'/../views/ManageInformation/HomeNavBar.php';
    }
}