<?php
require_once __DIR__.'/../controller.php';
require_once __DIR__.'/../../services/EventService.php';
 abstract class AdminPanelController extends Controller
{
    protected $eventService;
    public function __construct()
    {
        parent::__construct();
        $this->eventService = new EventService();
          //$this->checkLoggedInUserIsAdminstrator(); // checking if the logged user or not show that this page can be logged in if the user is not logged in or
        // if the user is not an administrator, it will redirect to the not allowed page.
    }
    protected function displaySideBar($title,$pathToCss=null): void
    {
        require_once __DIR__.'/../../views/AdminPanel/adminPanelSideBar.php';
    }
     private function checkLoggedInUserIsAdminstrator(): void
     {
         if (isset($_SESSION["loggedUser"])) {
             if (unserialize(serialize($_SESSION["loggedUser"]))->getRole() == Roles::Administrator()) {

             } else {
                 $this->displayPageView("NotAllowedPage");
                 exit(); // exit the controller if user is not admin
             }
         } else {
             header("location: /login");
             exit();
         }
     }

}