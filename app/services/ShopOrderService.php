<?php
require_once __DIR__ . '/../repositories/ShopOrderRepository.php';
class ShopOrderService
{
    private $shopOrderRepository;
    public function __construct()
    {
        $this->shopOrderRepository = new shopOrderRepository();
    }

    public function retrieveAllOrders()
    {
        return $this->shopOrderRepository->retrieveAllOrders();
    }

    public function getOrderById($id)
    {
        return $this->shopOrderRepository->getOrderById($id);
    }

    public function addOrder($orderId, $userId, $orderDate, $billId)
    {
        return $this->shopOrderRepository->addOrder($orderId, $userId, $orderDate, $billId);
    }

    public function retrievePreviousOrder()
    {
        return $this->shopOrderRepository->retrievePreviousOrder();
    }

    public function retrievePreviousOrderId()
    {
        return $this->shopOrderRepository->retrievePreviousOrderId();
    }
}