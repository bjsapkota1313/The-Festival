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
        $totalPrice = "";
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

        require_once __DIR__ . '/../../views/AdminPanel/History/shoppingCart.php';
    }

    public function getTotalPrice()
    {
        if (!empty($_SESSION['userId'])) {
            $userId = $_SESSION['userId'];
            $this->shoppingCartService->getTotalPriceByUserId($userId);
        }
    }

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
}