<?php
require_once __DIR__ . '/EventController.php';
require_once __DIR__ . '/../../Services/ShoppingCartService.php';

class ShoppingCartController extends EventController
{
    private $shoppingCartService;

    public function __construct()
    {
        parent::__construct();
        $this->shoppingCartService = new ShoppingCartService();
    }

    public function index()
    {
        $allItemsInShoppingCarts = "";
        $allRestaurantItems = "";
        $allPerformanceItems = "";
//        $totalPrice = "";
        if (!empty($_SESSION['userId'])) {
            $userId = $_SESSION['userId'];

            $allItemsInShoppingCarts = $this->shoppingCartService->getHistoryTourOrdersByUserId($userId);
            $allRestaurantItems = $this->shoppingCartService->getRestaurantOrdersByUserId($userId);
            $allPerformanceItems = $this->shoppingCartService->getPerformanceOrdersByUserId($userId);
            $totalPrice = $this->shoppingCartService->getTotalPriceByUserId($userId);
        } else {
            $orderId = $_COOKIE['orderId'] ?? '';
            $allItemsInShoppingCarts = $this->shoppingCartService->getHistoryTourOrdersByOrderId($orderId);
            $allRestaurantItems = $this->shoppingCartService->getRestaurantOrdersByUserId($orderId);
            $allPerformanceItems = $this->shoppingCartService->getPerformanceOrdersByOrderId($orderId);
            $totalPrice = $this->shoppingCartService->getTotalPriceByOrderId($orderId);
        }
        if (isset($_POST['payNow']) && !empty($_SESSION['userId'])) {
            $userId = $_SESSION['userId'];
            $orderId = $this->shoppingCartService->getOrderByUserId($userId);

            // Get payment parameters from form submission
            $amount = number_format($_POST["amount"], 2, '.', '');
            $description = $_POST["description"];
            $redirectUrl = $_POST["redirectUrl"];
            $webhookUrl = $_POST["webhookUrl"];

            //delete expired payment
            $this->shoppingCartService->deletePayment();

            // Create Mollie payment
            $payment = $this->shoppingCartService->createPayment($userId, $orderId, $amount, $description, $redirectUrl, $webhookUrl);
        }
        else if(isset($_POST['payNow']) && empty($_SESSION['userId'])){
            include __DIR__ . '/../../views/ShoppingCart/shoppingCartModal.php';
        }

        require_once __DIR__ . '/../../views/ShoppingCart/shoppingCart.php';
    }

//    public function getTotalPrice()
//    {
//        if (!empty($_SESSION['userId'])) {
//            $userId = $_SESSION['userId'];
//            $this->shoppingCartService->getTotalPriceByUserId($userId);
//        }
//    }

    public function paymentRedirect()
    {
        if (isset($_GET['orderID'])) {
            $orderId = htmlspecialchars($_GET['orderID']);
            $paymentCode = $this->shoppingCartService->getPaymentCodeByOrderId($orderId);
            $paymentStatus = $this->shoppingCartService->getPaymentStatusFromMollie($paymentCode);
            if ($paymentStatus == "paid") {
                $this->shoppingCartService->changePaymentToPaid($paymentCode, $orderId);
                header("Location: /festival/Dance");
                exit;
            } else {
                header("Location: /festival/ShoppingCart");
                exit;
            }
        }
    }
    public function updateQuantity()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $orderItemId = $_POST['orderItemId'];
            var_dump($orderItemId);
            $orderId = $this->shoppingCartService->getOrderIdByOrderItemId($orderItemId);
            var_dump($orderId);
            $quantity = $_POST['quantity'];
            $this->shoppingCartService->updateQuantity($orderItemId, $quantity);
            $this->shoppingCartService->updateTotalPrice($orderId);
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
        } else if (!empty($_SESSION['userId'])) {
            $orderId = $_COOKIE['orderId'];
            $this->shoppingCartService->getTotalPriceByOrderId($orderId);
        }
    }
}