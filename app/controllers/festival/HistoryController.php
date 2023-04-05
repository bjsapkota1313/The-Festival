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
//        if (isset($_POST["addTourToCart"])) {
//            if (empty($_SESSION['userId']) && empty($_SESSION['orderId'])) {
//                $orderId = $this->shoppingCartService->createOrder(null);
//                $_SESSION['orderId'] = $orderId;
//                $order = $this->shoppingCartService->getOrderByOrderId($orderId);
//                // Add the tour to the order
//                $newOrderItem = array(
//                    "orderId" => $order,
//                    "tourTicketDate" => htmlspecialchars($_POST["tourTicketDate"]),
//                    "tourTicketTime" => htmlspecialchars($_POST["tourTicketTime"]),
//                    "tourTicketType" => "single",
//                    "TourLanguage" => htmlspecialchars($_POST["TourLanguage"]),
//                );
//                $quantity = $_POST["tourSingleTicket"];
//                $ticketId = $this->shoppingCartService->getTicketId($newOrderItem);
////                var_dump($ticketId);
//                $orderItem = $this->shoppingCartService->getOrderItemIdByTicketId($ticketId);
//
//                if (!$orderItem) {
//                    $this->shoppingCartService->createOrderItem($order, $ticketId, $quantity);
//                } else {
//                    $this->shoppingCartService->updateOrderItemByTicketId($ticketId, $quantity);
//                }
//            }
//            else if(!empty($_SESSION['orderId'])){
//                $order = $this->shoppingCartService->getOrderByOrderId($_SESSION['orderId']);
//                // Add the tour to the order
//                $newOrderItem = array(
//                    "orderId" => $_SESSION['orderId'],
//                    "tourTicketDate" => htmlspecialchars($_POST["tourTicketDate"]),
//                    "tourTicketTime" => htmlspecialchars($_POST["tourTicketTime"]),
//                    "tourTicketType" => "single",
//                    "TourLanguage" => htmlspecialchars($_POST["TourLanguage"]),
//                );
//                $quantity = $_POST["tourSingleTicket"];
//                $ticketId = $this->shoppingCartService->getTicketId($newOrderItem);
////                var_dump($ticketId);
//                $orderItem = $this->shoppingCartService->getOrderItemIdByTicketId($ticketId);
//                $this->shoppingCartService->updateTotalPrice($_SESSION['orderId']);
//
//
//                if (!$orderItem) {
//                    $this->shoppingCartService->createOrderItem($_SESSION['orderId'], $ticketId, $quantity);
//                } else {
//                    $this->shoppingCartService->updateOrderItemByTicketId($ticketId, $quantity);
//                }
//            }
//            else{
//                $userId = $_SESSION['userId'];
//                $order = $this->shoppingCartService->getOrderByUserId($userId);
//                $newOrderItem = array(
//                    "orderId" => $order,
//                    "tourTicketDate" => htmlspecialchars($_POST["tourTicketDate"]),
//                    "tourTicketTime" => htmlspecialchars($_POST["tourTicketTime"]),
//                    "tourTicketType" => "single",
//                    "TourLanguage" => htmlspecialchars($_POST["TourLanguage"]),
//                );
//                $quantity = $_POST["tourSingleTicket"];
//                $ticketId = $this->shoppingCartService->getTicketId($newOrderItem);
////                var_dump($ticketId);
//                $orderItem = $this->shoppingCartService->getOrderItemIdByTicketId($ticketId);
//                // Check if there is an existing order for the user
//                if (!$order) {
//                    // Create a new order for the user
//                    $this->shoppingCartService->createOrder($userId);
//                    $order = $this->shoppingCartService->getOrderByUserId($userId);
//                }
//            }
//            // Add the tour to the order
//            $newOrderItem = array(
//                "orderId" => $order,
//                "tourTicketDate" => htmlspecialchars($_POST["tourTicketDate"]),
//                "tourTicketTime" => htmlspecialchars($_POST["tourTicketTime"]),
//                "tourTicketType" => "single",
//                "TourLanguage" => htmlspecialchars($_POST["TourLanguage"]),
//            );
//            $quantity = $_POST["tourSingleTicket"];
//            $ticketId = $this->shoppingCartService->getTicketId($newOrderItem);
//            $orderItem = $this->shoppingCartService->getOrderItemIdByTicketId($ticketId);
//            if (!$orderItem) {
//                $this->shoppingCartService->createOrderItem($order, $ticketId, $quantity);
//            } else {
//                $this->shoppingCartService->updateOrderItemByTicketId($ticketId, $quantity);
//            }

//        }
//        if (isset($_POST["addTourToCart"]) && empty($_SESSION['userId'])) {
//            $uniqueId = uniqid();
//            $_SESSION['uniqueId'] = $uniqueId;
//
//            // Check if shopping cart session variable exists, if not, create an empty array
//            if (!isset($_SESSION['shoppingCart'])) {
//                $_SESSION['shoppingCart'] = array();
//            }
//
//            // Add the item to the shopping cart session variable
//            $newOrderItem = [
//                "tourTicketDate" => htmlspecialchars($_POST["tourTicketDate"]),
//                "tourTicketTime" => htmlspecialchars($_POST["tourTicketTime"]),
//                "tourTicketType" => "single",
//                "TourLanguage" => htmlspecialchars($_POST["TourLanguage"]),
//                "tourSingleTicket" => htmlspecialchars($_POST["tourSingleTicket"])
//            ];
//
//            $_SESSION['shoppingCart'][] = $newOrderItem;
//
//
////            $ticketId = $this->shoppingCartService->getTicketId($newOrderItem);
//        } else if (isset($_POST["addTourToCart"]) && !empty($_SESSION['userId'])) {
//            $userId = $_SESSION['userId'];
//            $order = $this->shoppingCartService->getOrderByUserId($userId);
//            // Check if there is an existing order for the user
//            if (!$order) {
//                // Create a new order for the user
//                $this->shoppingCartService->createOrder($userId);
//                $order = $this->shoppingCartService->getOrderByUserId($userId);
//            }
//            // Add the tour to the order
//            $newOrderItem = array(
//                "orderId" => $order,
//                "tourTicketDate" => htmlspecialchars($_POST["tourTicketDate"]),
//                "tourTicketTime" => htmlspecialchars($_POST["tourTicketTime"]),
//                "tourTicketType" => "single",
//                "TourLanguage" => htmlspecialchars($_POST["TourLanguage"]),
//            );
//            $quantity = $_POST["tourSingleTicket"];
//            $ticketId = $this->shoppingCartService->getTicketId($newOrderItem);
//            $orderItem = $this->shoppingCartService->getOrderItemIdByTicketId($ticketId);
//            if (!$orderItem) {
//                $this->shoppingCartService->createOrderItem($order, $ticketId, $quantity);
//            } else {
//                $this->shoppingCartService->updateOrderItemByTicketId($ticketId, $quantity);
//                $this->shoppingCartService->updateTotalPrice($order);
//            }
//        }

        if (isset($_POST["addTourToCart"]) && empty($_SESSION['userId']) && empty($_SESSION['orderId'])) {
            $orderId = $this->shoppingCartService->createOrder(null);
            $_SESSION['orderId'] = $orderId;
            var_dump($_SESSION['orderId']);
//            $order = $this->shoppingCartService->getOrderByOrderId($orderId);
            // Add the tour to the order
            $newOrderItem = array(
                "orderId" => $orderId,
                "tourTicketDate" => htmlspecialchars($_POST["tourTicketDate"]),
                "tourTicketTime" => htmlspecialchars($_POST["tourTicketTime"]),
                "tourTicketType" => "single",
                "TourLanguage" => htmlspecialchars($_POST["TourLanguage"]),
            );
            $quantity = $_POST["tourSingleTicket"];
            $ticketId = $this->shoppingCartService->getTicketId($newOrderItem);
//                var_dump($ticketId);
            $orderItem = $this->shoppingCartService->getOrderItemIdByTicketId($ticketId,$orderId);

            if (!$orderItem) {
                $this->shoppingCartService->createOrderItem($orderId, $ticketId, $quantity);
            } else {
                $this->shoppingCartService->updateOrderItemByTicketId($ticketId, $quantity);
            }

//            $ticketId = $this->shoppingCartService->getTicketId($newOrderItem);
        } else if (isset($_POST["addTourToCart"]) && !empty($_SESSION['orderId']) && empty($_SESSION['userId'])) {
            var_dump($_SESSION['orderId']);

            $orderId = $this->shoppingCartService->getOrderByOrderId($_SESSION['orderId']);
            // Add the tour to the order
            $newOrderItem = array(
                "orderId" => $orderId,
                "tourTicketDate" => htmlspecialchars($_POST["tourTicketDate"]),
                "tourTicketTime" => htmlspecialchars($_POST["tourTicketTime"]),
                "tourTicketType" => "single",
                "TourLanguage" => htmlspecialchars($_POST["TourLanguage"]),

            );
            $quantity = $_POST["tourSingleTicket"];
            $ticketId = $this->shoppingCartService->getTicketId($newOrderItem);
//                var_dump($ticketId);
            $orderItem = $this->shoppingCartService->getOrderItemIdByTicketId($ticketId,$orderId);
            $this->shoppingCartService->updateTotalPrice($_SESSION['orderId']);


            if (!$orderItem) {
                $this->shoppingCartService->createOrderItem($_SESSION['orderId'], $ticketId, $quantity);
            } else {
                $this->shoppingCartService->updateOrderItemByTicketId($ticketId, $quantity);
            }
        } else if (isset($_POST["addTourToCart"]) && !empty($_SESSION['userId'])) {
            $userId = $_SESSION['userId'];
            $orderId = $this->shoppingCartService->getOrderByUserId($userId);
            // Check if there is an existing order for the user
            if (!$orderId) {
                // Create a new order for the user
                $this->shoppingCartService->createOrder($userId);
                $orderId = $this->shoppingCartService->getOrderByUserId($userId);
            }
            // Add the tour to the order
            $newOrderItem = array(
                "orderId" => $orderId,
                "tourTicketDate" => htmlspecialchars($_POST["tourTicketDate"]),
                "tourTicketTime" => htmlspecialchars($_POST["tourTicketTime"]),
                "tourTicketType" => "single",
                "TourLanguage" => htmlspecialchars($_POST["TourLanguage"]),
            );
            $quantity = $_POST["tourSingleTicket"];
            $ticketId = $this->shoppingCartService->getTicketId($newOrderItem);
            $orderItem = $this->shoppingCartService->getOrderItemIdByTicketId($ticketId,$orderId);
            if (!$orderItem) {
                $this->shoppingCartService->createOrderItem($orderId, $ticketId, $quantity);
            } else {
                $this->shoppingCartService->updateOrderItemByTicketId($ticketId, $quantity);
                $this->shoppingCartService->updateTotalPrice($orderId);
            }
        }

        require __DIR__ . '/../../views/festival/History/ticketSelection.php';
    }

    public function shoppingCart()
    {
//        unset($_SESSION['shoppingCart']);
//        $_SESSION['shoppingCart'] = array();
//        if (isset($_SESSION['shoppingCart'])) {
////            $historyOrderItem = array();
//            var_dump($_SESSION['shoppingCart']);
//
////            $historyOrderItem = $_SESSION['shoppingCart'];
////            $allItemsInShoppingCarts = $_SESSION['shoppingCart'];
//            $allItemsInShoppingCarts = $this->shoppingCartService->damn($_SESSION['shoppingCart']);
////            var_dump($historyOrderItem);
////            $allItemsInShoppingCarts = $this->shoppingCartService->damn($_SESSION['shoppingCart']);
////            var_dump($allItemsInShoppingCarts);
//
//            $allRestaurantItems = array();
//        }
        if (!empty($_SESSION['userId'])) {
            $userId = $_SESSION['userId'];

            $allItemsInShoppingCarts = $this->shoppingCartService->getHistoryTourOrdersByUserId($userId);
            $allRestaurantItems = $this->shoppingCartService->getRestaurantOrdersByUserId($userId);
            $totalPrice = $this->shoppingCartService->getTotalPriceByUserId($userId);
        } else {
            $orderId = $_SESSION['orderId'];
            var_dump($orderId);
            $allItemsInShoppingCarts = $this->shoppingCartService->getHistoryTourOrdersByOrderId($orderId);
            $allRestaurantItems = $this->shoppingCartService->getRestaurantOrdersByUserId($orderId);
            $totalPrice = $this->shoppingCartService->getTotalPriceByOrderId($orderId);
        }

        if (isset($_POST['payNow'])) {
            // Get payment parameters from form submission
            $amount = number_format($_POST["amount"], 2, '.', '');
            $description = $_POST["description"];
            $redirectUrl = $_POST["redirectUrl"];
            $webhookUrl = $_POST["webhookUrl"];

            // Create Mollie payment
            $payment = $this->shoppingCartService->createPayment($amount, $description, $redirectUrl, $webhookUrl);

            echo "<script>window.location.replace('" . $payment->getCheckoutUrl() . "');</script>";

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

//        print_r($historyEvent);
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

    public function updateQuantity()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//            $orderItemId = $_POST['orderItemId'];
//            $orderId = $this->shoppingCartService->getOrderIdByOrderItemId($orderItemId);
//            $quantity = $_POST['quantity'];
//            $this->shoppingCartService->updateQuantity($orderItemId, $quantity);
//            $this->shoppingCartService->updateTotalPrice($orderId);
            if (!empty($_SESSION['userId'])) {
                $orderItemId = $_POST['orderItemId'];
                var_dump($orderItemId);
                $orderId = $this->shoppingCartService->getOrderIdByOrderItemId($orderItemId);
                var_dump($orderId);
                $quantity = $_POST['quantity'];
                $this->shoppingCartService->updateQuantity($orderItemId, $quantity);
                $this->shoppingCartService->updateTotalPrice($orderId);
            } else {
                $orderItemId = $_POST['orderItemId'];
                $quantity = $_POST['quantity'];
                var_dump($orderItemId);

                $this->shoppingCartService->updateSessionShoppingCartItem(unserialize(serialize($_SESSION['shoppingCart'])), $orderItemId, $quantity);
            }
            else{
                $orderItemId = $_POST['orderItemId'];
                $quantity = $_POST['quantity'];
                var_dump($orderItemId);
//                print_r($_SESSION['shoppingCart']);
//                var_dump($_POST);
//                var_dump($orderItemId);
//                var_dump($quantity);
                $this->shoppingCartService->updateSessionShoppingCartItem(unserialize(serialize($_SESSION['shoppingCart'])), $orderItemId, $quantity);
            }
        }
    }

    public function deleteOrderItem()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $orderItemId = $_POST['orderItemId'];
            $this->shoppingCartService->deleteOrderItem($orderItemId);
        }
    }

    public function getTotalPrice()
    {
        if (!empty($_SESSION['userId'])) {
            $userId = $_SESSION['userId'];
            $this->shoppingCartService->getTotalPriceByUserId($userId);
        }
    }
}