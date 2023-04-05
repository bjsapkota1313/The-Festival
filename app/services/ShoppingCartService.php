<?php

use Mollie\Api\MollieApiClient;

require_once __DIR__ . '/../repositories/ShoppingCartRepository.php';
require_once __DIR__ . '/../mollie/vendor/autoload.php';

class ShoppingCartService
{

    private $shoppingCartRepository;
    private $mollie;


    public function __construct()
    {
        $this->shoppingCartRepository = new ShoppingCartRepository();
        $this->mollie = new MollieApiClient();
        $this->mollie->setApiKey('test_Ds3fz4U9vNKxzCfVvVHJT2sgW5ECD8');
    }

    public function getOrderByUserId($userId)
    {
        return $this->shoppingCartRepository->getOrderByUserId($userId);
    }

    public function createOrder($userId)
    {
        return $this->shoppingCartRepository->createOrder($userId);
    }

    public function getTicketId($test)
    {
        return $this->shoppingCartRepository->getTicketId($test);
    }

    public function createOrderItem($orderId, $ticketId, $quantity)
    {
        return $this->shoppingCartRepository->createOrderItem($orderId, $ticketId, $quantity);
    }

    public function getHistoryTourOrdersByUserId($userId)
    {
        return $this->shoppingCartRepository->getHistoryTourOrdersByUserId($userId);

    }
    public function getHistoryTourOrdersByOrderId($orderId){
        return $this->shoppingCartRepository->getHistoryTourOrdersByOrderId($orderId);

    }

    public function getOrderItemIdByTicketId($ticketId,$order)
    {
        return $this->shoppingCartRepository->getOrderItemIdByTicketId($ticketId,$order);
    }
    public function getPerformanceOrderItemIdByTicketId($ticketId,$order){
        return $this->shoppingCartRepository->getPerformanceOrderItemIdByTicketId($ticketId,$order);
    }

    public function updateOrderItemByTicketId($ticketId, $quantity)
    {
        return $this->shoppingCartRepository->updateOrderItemByTicketId($ticketId, $quantity);
    }

    public function updateQuantity($itemId, $quantity)
    {
        return $this->shoppingCartRepository->updateQuantity($itemId, $quantity);
    }

    public function deleteOrderItem($orderItemId)
    {
        return $this->shoppingCartRepository->deleteOrderItem($orderItemId);
    }

    public function getRestaurantOrdersByUserId($userId)
    {
        return $this->shoppingCartRepository->getRestaurantOrdersByUserId($userId);
    }

    public function getOrderIdByOrderItemId($orderItemId)
    {
        $this->shoppingCartRepository->getOrderIdByOrderItemId($orderItemId);
    }

    public function updateTotalPrice($orderId)
    {
        $this->shoppingCartRepository->updateTotalPrice($orderId);
    }

    public function getTotalPriceByUserId($userId)
    {
        return $this->shoppingCartRepository->getTotalPriceByUserId($userId);
    }
    public function getTotalPriceByOrderId($orderId)
    {
        return $this->shoppingCartRepository->getTotalPriceByOrderId($orderId);
    }

    public function createPayment($amount, $description, $redirectUrl, $webhookUrl)
    {
        $payment = $this->mollie->payments->create([
            "amount" => [
                "currency" => "EUR",
                "value" => $amount
            ],
            "description" => $description,
            "redirectUrl" => $redirectUrl,
            "webhookUrl" => $webhookUrl
        ]);

        return $payment;
    }

    public function damn($historyOrder)
    {
        $historyOrderItem = array();
        foreach ($historyOrder as $order) {
            $historyOrderItem[] = $this->createShoppingCartSession($historyOrder, $order);
        }
        return $historyOrderItem;
    }

    public function deleteSessionShoppingCartItem($historyOrder, $selectedId)
    {
        foreach ($historyOrder as $item) {
            if($selectedId == $item->getOrderItemId()){
                unset($historyOrder[$item]);
            }
        }
    }
    public function updateSessionShoppingCartItem($historyOrder, $selectedId, $quantity)
    {
        foreach ($historyOrder as $item) {
            if ($selectedId == $item->getOrderItemId()) {
                $item->setQuantity($quantity);
                break;
            }
        }
    }


    public function createShoppingCartSession($test, $historyOrders)
    {
        static $id = 1; // Initialize $id only once, and keep track of its value across function calls.

        $historyOrderItem = new HistoryTourOrderItem();
        $historyOrderItem->setOrderItemId($id);
        $historyOrderItem->setPrice(10);
        $historyOrderItem->setTicketType($historyOrders['tourTicketType']);
        $historyOrderItem->setLanguage($historyOrders['TourLanguage']);
        $historyOrderItem->setQuantity((int)$historyOrders['tourSingleTicket']);

        $id += 1; // Increment $id after setting the order item id for the current history order.

        return $historyOrderItem;
    }
    public function getOrderByOrderId($orderId){
        return $this->shoppingCartRepository->getOrderByOrderId($orderId);
    }
    public function updateOrderStatus($orderId, $newOrderStatus) {
        return $this->shoppingCartRepository->updateOrderStatus($orderId,$newOrderStatus);
    }
    public function getPerformanceOrdersByUserId($userId){
        return $this->shoppingCartRepository->getPerformanceOrdersByUserId($userId);
    }
//    public function createShoppingCartSession($historyOrder){
//        var_dump($historyOrder);
//        $historyOrderItem = new HistoryTourOrderItem();
//        $historyOrderItem->setOrderItemId(1);
//        $historyOrderItem->setQuantity(1);
//        $historyOrderItem->setTicketType('single');
//        $historyOrderItem->setPrice(10);
//        $historyOrderItem->setLanguage('english');
//
//        return $historyOrderItem;
//    }
//    public function createShoppingCartSession($historyOrder)
//    {
//        $historyOrderItem = new HistoryTourOrderItem();
//        var_dump($historyOrder);
//
//        $historyOrderItem->setOrderItemId(1);
//        $historyOrderItem->setPrice(10);
//        $historyOrderItem->setTicketType(strval($historyOrder[2]));
//        $historyOrderItem->setLanguage(strval($historyOrder[3]));
//        $historyOrderItem->setQuantity(intval($historyOrder[4]));
//
//
//        return $historyOrderItem;
//    }
//    public function createShoppingCartSession($historyOrders)
//    {
//
//        $historyOrderItem = new HistoryTourOrderItem();
//        $historyOrderItem->setOrderItemId(1);
//        $historyOrderItem->setPrice(10);
//        $historyOrderItem->setTicketType($historyOrders['tourTicketType']);
//        $historyOrderItem->setLanguage($historyOrders['TourLanguage']);
//        $historyOrderItem->setQuantity((int)$historyOrders['tourSingleTicket']);
//        var_dump($historyOrderItem);
//
//        return $historyOrderItem;
//    }


}
//        $historyOrderItem->setPrice($this->shoppingCartRepository->getTicketId($historyOrder));