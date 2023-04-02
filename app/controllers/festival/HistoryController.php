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
//    public function ticketSelection(){ //working code
//        if(empty($_SESSION['userId'])){
//            $_SESSION['userId'] = null;
//        }
//        $userId = $_SESSION['userId'];
//
//        if (isset($_POST["addTourToCart"])) {
//            $order = $this->shoppingCartService->getOrderByUserId($userId);
//            // Check if there is an existing order for the user
//            if (!$order) {
//                // Create a new order for the user
//                $this->shoppingCartService->createOrder($userId);
//                $order = $this->shoppingCartService->getOrderByUserId($userId);
//            }
//
//            // Add the tour to the order
//            $newOrderItem = array(
//                "orderId" => $order,
//                "tourTicketDate" => htmlspecialchars($_POST["tourTicketDate"]),
//                "tourTicketTime" => htmlspecialchars($_POST["tourTicketTime"]),
//                "tourTicketType" => "single",
//                "TourLanguage" => "english",
//            );
//            $ticketId = $this->shoppingCartService->getTicketId($newOrderItem);
//            $this->shoppingCartService->createOrderItem($order,$ticketId,12);
//        }
//
//        require __DIR__ . '/../../views/festival/History/ticketSelection.php';
//    }

    public function ticketSelection()
    {
        if (isset($_POST["addTourToCart"]) && empty($_SESSION['userId'])) {
            $uniqueId = uniqid();
            $_SESSION['uniqueId'] = $uniqueId;

            // Check if shopping cart session variable exists, if not, create an empty array
            if (!isset($_SESSION['shoppingCart'])) {
                $_SESSION['shoppingCart'] = array();
            }

            // Add the item to the shopping cart session variable
            $newOrderItem = array(
                "tourTicketDate" => htmlspecialchars($_POST["tourTicketDate"]),
                "tourTicketTime" => htmlspecialchars($_POST["tourTicketTime"]),
                "tourTicketType" => "single",
                "TourLanguage" => htmlspecialchars($_POST["TourLanguage"]),
            );
            $_SESSION['shoppingCart'][] = $newOrderItem;
        } else if (isset($_POST["addTourToCart"]) && !empty($_SESSION['userId'])) {
            $userId = $_SESSION['userId'];
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
                "TourLanguage" => htmlspecialchars($_POST["TourLanguage"]),
            );
            $quantity = $_POST["tourSingleTicket"];
            $ticketId = $this->shoppingCartService->getTicketId($newOrderItem);
            $orderItem = $this->shoppingCartService->getOrderItemIdByTicketId($ticketId);
            if(!$orderItem){
                $this->shoppingCartService->createOrderItem($order, $ticketId, $quantity);
            }
            else{
                $this->shoppingCartService->updateOrderItemByTicketId($ticketId, $quantity);
            }
        }

        require __DIR__ . '/../../views/festival/History/ticketSelection.php';
    }

    public function shoppingCart()
    {
        if (empty($_SESSION['userId'])) {
            $allItemsInShoppingCarts = $_SESSION['shoppingCart'];
        }
        $userId = $_SESSION['userId'];

        $allItemsInShoppingCarts = $this->shoppingCartService->getHistoryTourOrdersByUserId($userId);
        $allRestaurantItems = $this->shoppingCartService->getRestaurantOrdersByUserId($userId);
        $totalPrice = $this->shoppingCartService->getTotalPriceByUserId($userId);

        if (isset($_POST['payNow'])) {
            // Get payment parameters from form submission
            $amount = number_format($_POST["amount"], 2, '.', '');
            $description = $_POST["description"];
            $redirectUrl = $_POST["redirectUrl"];
            $webhookUrl = $_POST["webhookUrl"];

            // Create Mollie payment
            $payment = $this->shoppingCartService->createPayment($amount, $description, $redirectUrl, $webhookUrl);

            echo "<script>window.location.replace('" . $payment->getCheckoutUrl() . "');</script>";

//            // Redirect user to Mollie payment page
//            header("Location: " . $payment->getCheckoutUrl());
//            exit();
        }

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

    public function updateQuantity() {
        if($_SERVER['REQUEST_METHOD']==='POST'){
            if(!empty($_SESSION['userId'])){
                $orderItemId = $_POST['orderItemId'];
                $orderId = $this->shoppingCartService->getOrderIdByOrderItemId($orderItemId);
                $quantity = $_POST['quantity'];
                $this->shoppingCartService->updateQuantity($orderItemId, $quantity);
                $this->shoppingCartService->updateTotalPrice($orderId);
            }
        }
    }
    public function deleteOrderItem(){
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $orderItemId = $_POST['orderItemId'];
            $this->shoppingCartService->deleteOrderItem($orderItemId);
        }
    }
    public function getTotalPrice(){
        if (!empty($_SESSION['userId'])) {
            $userId = $_SESSION['userId'];
            $this->shoppingCartService->getTotalPriceByUserId($userId);
        }
    }
}