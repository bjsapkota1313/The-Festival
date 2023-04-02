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

    public function createOrderItem($userId, $ticketId, $quantity)
    {
        return $this->shoppingCartRepository->createOrderItem($userId, $ticketId, $quantity);
    }

    public function getHistoryTourOrdersByUserId($userId)
    {
        return $this->shoppingCartRepository->getHistoryTourOrdersByUserId($userId);

    }

    public function getOrderItemIdByTicketId($ticketId)
    {
        return $this->shoppingCartRepository->getOrderItemIdByTicketId($ticketId);
    }

    public function updateOrderItemByTicketId($ticketId, $quantity)
    {
        return $this->shoppingCartRepository->updateOrderItemByTicketId($ticketId, $quantity);
    }
    public function updateQuantity($itemId,$quantity){
        return $this->shoppingCartRepository->updateQuantity($itemId, $quantity);
    }
    public function deleteOrderItem($orderItemId){
        return $this->shoppingCartRepository->deleteOrderItem($orderItemId);
    }
    public function getRestaurantOrdersByUserId($userId) {
        return $this->shoppingCartRepository->getRestaurantOrdersByUserId($userId);
    }
    public function getOrderIdByOrderItemId($orderItemId){
        $this->shoppingCartRepository->getOrderIdByOrderItemId($orderItemId);
    }
    public function updateTotalPrice($orderId){
        $this->shoppingCartRepository->updateTotalPrice($orderId);
    }
    public function getTotalPriceByUserId($userId){
        $this->shoppingCartRepository->getTotalPriceByUserId($userId);
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
}