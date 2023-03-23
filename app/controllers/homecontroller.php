<?php
require_once __DIR__ . '/controller.php';
require_once __DIR__ . '/pagecontroller.php';
require_once __DIR__ . '/../services/userService.php';



class HomeController extends Controller
{
    
    private $userService;
    private $currentUserId;
    private $pageController;

    // initialize services
    function __construct()
    {
        parent::__construct();
        $this->userService = new UserService();
        if(isset($_SESSION["loggedUser"])){
            $this->currentUserId = unserialize(serialize($_SESSION["loggedUser"]))->getId();
        }
        $this->pageController = new PageController();

    }

    public function index()
    {
        $this->displayNavBar("HomePage",'/css/homePageStyle.css');
        $currentUserId = $this->currentUserId;
        $this->pageController->show("title=newtest", $currentUserId);
        $this->displayFooter();
    }

}?>
