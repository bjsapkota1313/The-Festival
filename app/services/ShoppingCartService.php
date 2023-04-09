<?php

use Mollie\Api\Exceptions\ApiException;
use Mollie\Api\MollieApiClient;

require_once __DIR__ . '/../repositories/ShoppingCartRepository.php';
require_once __DIR__ . '/../mollie/vendor/autoload.php';

class ShoppingCartService
{

    private $shoppingCartRepository;
    private $mollie;


    /**
     * @throws ApiException
     */
    public function __construct()
    {
        $this->shoppingCartRepository = new ShoppingCartRepository();
        $this->mollie = new MollieApiClient();
        $this->mollie->setApiKey('test_pWakjcMGpJvgppb92Jb7D2NvvDhB5n');
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

    public function createPerformanceOrderItem($orderId, $ticketId, $quantity)
    {
        return $this->shoppingCartRepository->createPerformanceOrderItem($orderId, $ticketId, $quantity);
    }


    public function getHistoryTourOrdersByUserId($userId)
    {
        return $this->shoppingCartRepository->getHistoryTourOrdersByUserId($userId);

    }

    public function getHistoryTourOrdersByOrderId($orderId)
    {
        return $this->shoppingCartRepository->getHistoryTourOrdersByOrderId($orderId);

    }
    public function getPerformanceOrdersByOrderId($orderId){
        return $this->shoppingCartRepository->getPerformanceOrdersByOrderId($orderId);
    }

    public function getOrderItemIdByTicketId($ticketId, $order)
    {
        return $this->shoppingCartRepository->getOrderItemIdByTicketId($ticketId, $order);
    }

    public function getPerformanceOrderItemIdByTicketId($ticketId, $order)
    {
        return $this->shoppingCartRepository->getPerformanceOrderItemIdByTicketId($ticketId, $order);
    }

    public function updateOrderItemByTicketId($ticketId, $quantity)
    {
        return $this->shoppingCartRepository->updateOrderItemByTicketId($ticketId, $quantity);
    }

    public function getPerformanceTicketIdByPerformanceId($performanceId)
    {
        return $this->shoppingCartRepository->getPerformanceTicketIdByPerformanceId($performanceId);

    }

    public function updatePerformanceOrderItemByTicketId($ticketId, $quantity)
    {
        return $this->shoppingCartRepository->updatePerformanceOrderItemByTicketId($ticketId, $quantity);
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

    /**
     * @throws ApiException
     * @throws Exception
     */
    public function createPayment($userId, $orderId, $amount, $description, $redirectUrl, $webhookUrl)
    {
        $paymentId = $this->shoppingCartRepository->getPaymentIdByOrderId($orderId);

        if (!$paymentId) {
            $payment = $this->mollie->payments->create([
                "amount" => [
                    "currency" => "EUR",
                    "value" => $amount,
                ],
                "description" => "Order #{$userId}",
                "redirectUrl" => $redirectUrl,
                "webhookUrl" => $webhookUrl,
            ]);
            $checkoutUrl = $payment->getCheckoutUrl();
            $paymentId = $this->shoppingCartRepository->insertPaymentDetail($userId, $orderId, $payment->status, $payment->id, $checkoutUrl,);
        }
        $paymentStatus = $this->shoppingCartRepository->getOrderStatus($orderId);
        $checkoutUrl = $this->shoppingCartRepository->getCheckoutUrl($orderId);
//        var_dump($checkoutUrl);
        $test = $this->shoppingCartRepository->getPaymentCode($orderId);
        var_dump($test);

        $payment = $this->mollie->payments->get($test);
        $paymenthoho = $test;


        if ($payment->isPaid() || $payment->isAuthorized()) {
            $this->shoppingCartRepository->updatePaymentStatus($paymentId, 'paid');
        } elseif ($payment->isCanceled()) {
            $this->shoppingCartRepository->updatePaymentStatus($paymentId, 'canceled');
        } elseif ($payment->isExpired()) {
            $this->shoppingCartRepository->updatePaymentStatus($paymentId, 'expired');
            /*
             * The order is expired.
             */
        } elseif ($payment->isPending()) {
            $this->shoppingCartRepository->updatePaymentStatus($paymentId, 'pending');
            /*
             * The order is pending.
             */
        }
//        $checkoutUrl = $payment->getCheckoutUrl();
//        $_SESSION['checkoutUrl'] = $checkoutUrl;

//        echo "<script>window.location.replace('" . $checkoutUrl . "');</script>";

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
            if ($selectedId == $item->getOrderItemId()) {
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

    public function getOrderByOrderId($orderId)
    {
        return $this->shoppingCartRepository->getOrderByOrderId($orderId);
    }

    public function updateOrderStatus($orderId, $newOrderStatus)
    {
        return $this->shoppingCartRepository->updateOrderStatus($orderId, $newOrderStatus);
    }
    public function deletePayment(){
        return $this->shoppingCartRepository->deletePayment();
    }

    public function getPerformanceOrdersByUserId($userId)
    {
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
