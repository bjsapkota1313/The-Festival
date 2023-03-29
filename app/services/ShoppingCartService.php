<?php
require_once __DIR__ . '/../repositories/ShoppingCartRepository.php';

class ShoppingCartService
{

    private $shoppingCartRepository;

    public function __construct()
    {
        $this->shoppingCartRepository = new ShoppingCartRepository();
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

    public function getAllOrdersByUserId($userId)
    {
        return $this->shoppingCartRepository->getAllOrdersByUserId($userId);

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
}