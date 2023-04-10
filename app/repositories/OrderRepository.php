<?php
require_once __DIR__ . '/EventRepository.php';
require_once __DIR__ . '/../services/UserService.php';
require_once __DIR__ . '/../models/Order.php';

class OrderRepository extends EventRepository
{
    private $userServices;

    public function __construct()
    {
        parent::__construct();
        $this->userServices = new UserService();
    }

    public function getAllOrders()
        // this will retrieve all orders Paid from the database
    {
        $query = "SELECT ord.orderId, ord.user_id, ord.order_date, ord.totalPrice
                   FROM `order` as ord
                   JOIN payment ON ord.orderId = payment.orderId
                    WHERE payment.paymentStatus = 'Paid'";
        $dbResult = $this->executeQuery($query);
        if(empty($dbResult)){
            return null;
        }
        $orders = array();
        foreach ($dbResult as $dbRow) {
            $orders[] = $this->createOrderInstance($dbRow);
        }

    }

    private function createOrderInstance($dbRow)
    {
        $orderingCustomer = $this->userServices->getUserById($dbRow['user_id']);
        $order = new Order();
        $order->setOrderId($dbRow['orderId']);
        $order->setCustomer($orderingCustomer);
        $order->setOrderDate(new DateTime($dbRow['order_date']));
        print_r($order);

    }


}