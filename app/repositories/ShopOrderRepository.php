<?php
require_once __DIR__ . '/repository.php';
require_once __DIR__ . '/../models/shopOrder.php';


class ShopOrderRepository extends repository
{
    public function retrieveAllOrders()
    {

        try {

            $stmt = $this->connection->prepare("SELECT * FROM shoporder");

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_CLASS, 'ShopOrder');

        } catch (PDOException $e) {
            echo $e;
        }
    }


    public function retrievePreviousOrder()
    {
        try {

            $orders = $this->retrieveAllOrders();
            $previousOrder = end($orders);
            return $previousOrder;

        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function retrievePreviousOrderId()
    {
        $previousOrder = $this->retrievePreviousOrder();
        if ($previousOrder != NULL) {
            $previousOrderId = $previousOrder->getOrderId();
        } else {
            $previousOrderId = 0;
        }
        return $previousOrderId;
    }

    private function checkOrderExistence($stmt): bool
    {
        try {
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            $message = '[' . date("F j, Y, g:i a e O") . ']' . $e->getMessage() . $e->getCode() . $e->getFile() . ' Line ' . $e->getLine() . PHP_EOL;
            error_log("Database connection failed: " . $message, 3, __DIR__ . "/../Errors/error.log");
            http_response_code(500);
            exit();
        }
    }


    public function getOrderById($id)
    {
        try {

            $stmt = $this->connection->prepare("SELECT * From order WHERE orderId LIKE :id");
            $stmt->bindValue(':id', $id);
            if ($this->checkOrderExistence($stmt)) {
                $stmt->execute();
                $result = $stmt->fetch();
                return $result;

            }

        } catch (PDOException $e) {
            echo $e;
        }
    }


    public function addOrder($orderId, $userId, $orderDate, $billId)
    {
        $stmt = $this->connection->prepare("INSERT INTO order(orderId, userId, orderDate, billId)VALUES(:orderId, :userId, :orderDate, :billId)");
        $stmt->bindParam(':orderId', $orderId);
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':orderDate', $orderDate);
        $stmt->bindParam(':billId', $billId);

        $stmt->execute();
    }

}