<?php
require_once __DIR__ . '/EventController.php';
require_once __DIR__ . '/../../services/HistoryService.php';
require_once __DIR__ . '/../../services/ShoppingCartService.php';

class HistoryController extends EventController
{
    protected HistoryService $historyService;
    protected ShoppingCartService $shoppingCartService;

    public function __construct()
    {
        parent::__construct();
        $this->historyService = new HistoryService();
        $this->shoppingCartService = new ShoppingCartService();
    }

    public function index()
    {
        $allTourLocations = $this->historyService->getAllHistoryTourLocation();
        $this->displayNavBar("A stroll Through History", '/css/festival/history.css');
        $historyEvent = $this->eventService->getEventByName('A Stroll Through History');
        $historyTours = $historyEvent->getHistoryTours();
        $timetable = $this->getarrayAccordingToDate($historyTours);
//        $startingTourLocation = $this->historyService->getHistoryTourLocationsByHistoryTourId(1);

        require __DIR__ . '/../../views/festival/History/index.php';
    }

    public function detail()
    {

        $locationId = $_GET["locationId"];
        $location = $_GET["location"];
        $locationPostCode = $_GET["locationPostCode"];
//        $getLocationParagraphsById = $this->historyService->getHistoryTourLocationsByLocationName(3);
        $historyTourLocationObject = $this->historyService->getHistoryTourLocationByLocationId($locationId);

//        $tourImage = $getLocationParagraphsById->getTourImage();


        $this->displayNavBar("A stroll Through History", '/css/festival/history.css');

        require __DIR__ . '/../../views/festival/History/detail.php';
    }
    public function ticketSelection(){
        if(empty($_SESSION['userId'])){
            $_SESSION['userId'] = null;
        }
        $userId = $_SESSION['userId'];

        if (isset($_POST["addTourToCart"])) {
            $order = $this->shoppingCartService->getOrderByUserId($userId);
            // Check if there is an existing order for the user
            if (!$order) {
                // Create a new order for the user
                $this->shoppingCartService->createOrder($userId);
                $order = $this->shoppingCartService->getOrderByUserId($userId);
            }

            // Add the tour to the order
            $newOrderItem = array(
                "orderId" => $order,
                "tourTicketDate" => htmlspecialchars($_POST["tourTicketDate"]),
                "tourTicketTime" => htmlspecialchars($_POST["tourTicketTime"]),
                "tourTicketType" => "single",
                "TourLanguage" => "english",
//                "tourFamilyTicket" => htmlspecialchars($_POST["tourFamilyTicket"]),
            );
            $ticketId = $this->shoppingCartService->getTicketId($newOrderItem);
            $this->shoppingCartService->createOrderItem($order,$ticketId,12);
        }

        require __DIR__ . '/../../views/festival/History/ticketSelection.php';
    }

    public function shoppingCart(){
        if(empty($_SESSION['userId'])){
            $_SESSION['userId'] = null;
        }
        $userId = $_SESSION['userId'];
//        $title = 'Add Tour Location';
//        $this->displaySideBar($title);
        $allItemsInShoppingCarts = $this->shoppingCartService->getAllOrdersByUserId($userId);
        require_once __DIR__ . '/../../views/AdminPanel/History/shoppingCart.php';
    }

    public function getAllHistoryTourLocation()
    {
        $allTourLocation = $this->historyService->getAllHistoryTourLocation();
    }

    public function test()
    {
        $historyEvent = $this->eventService->getEventByName('A Stroll Through History');

        print_r($historyEvent);
    }

    private function getarrayAccordingToDate($historyTours)
    {
        // Group the tours by date and time
        $groupedHistoryTours = array();
        foreach ($historyTours as $historyTour) {
            $date = $historyTour->getTourDate()->format('Y-m-d');
            $time = $historyTour->getTourDate()->format('H:i');
            if (!isset($groupedHistoryTours[$date])) {
                $groupedHistoryTours[$date] = array();
            }
            if (!isset($groupedHistoryTours[$date][$time])) {
                $groupedHistoryTours[$date][$time] = array();
            }
            $groupedHistoryTours[$date][$time][] = $historyTour;
        }
        return $groupedHistoryTours;
    }
}