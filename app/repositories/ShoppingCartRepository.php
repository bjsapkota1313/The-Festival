<?php
require_once __DIR__ . '/EventRepository.php';
require_once __DIR__ . '/../models/OrderItem.php';


class ShoppingCartRepository extends EventRepository
{
    public function getOrderByUserId($userId){
        try {
            $stmt = $this->connection->prepare("SELECT orderId FROM `order` WHERE user_id = :user_id;");
            $stmt->bindValue(':user_id', $userId);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['orderId'];

        } catch (PDOException $e) {
            // Handle the exception here
            // For example, you could log the error message and return null
            error_log("Error fetching order for user ID $userId: " . $e->getMessage());
            return null;
        }
    }
    public function createOrder($userId){
        try {
            $stmt = $this->connection->prepare("INSERT INTO `order` (user_id, order_date, orderStatus) VALUES (:user_id, NOW(), 'open');");
            $stmt->bindValue(':user_id', $userId);
            $stmt->execute();
        } catch (PDOException $e) {
            // handle the error here, for example:
            echo "Error creating order: " . $e->getMessage();
            // or redirect to an error page
        }
    }
    public function getTicketId($newOrderItem) {
        $stmt = $this->connection->prepare("SELECT testticket.id
                                        FROM historytour
                                        JOIN language ON language.languageId = historytour.languageId
                                        JOIN timetable ON timetable.timeTableId = historytour.timeTableId
                                        JOIN testticket ON testticket.historyTourId = historytour.historyTourId
                                        JOIN eventdate ON eventdate.eventDateId = timetable.eventDateId
                                        WHERE language.name = :name
                                        AND testticket.ticket_type = :ticket_type
                                        AND eventdate.date = :date
                                        AND timetable.time = :time");

        $stmt->bindParam(':name', $newOrderItem['TourLanguage'], PDO::PARAM_STR);
        $stmt->bindParam(':ticket_type', $newOrderItem['tourTicketType'], PDO::PARAM_STR);
        $tourTicketDate = date('Y-m-d', strtotime($newOrderItem['tourTicketDate']));
        $stmt->bindParam(':date', $tourTicketDate, PDO::PARAM_STR);
        $stmt->bindParam(':time', $newOrderItem['tourTicketTime'], PDO::PARAM_STR);

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['id'];
    }
    public function createOrderItem($userId, $ticketId, $quantity) {
        $stmt = $this->connection->prepare("INSERT INTO orderitem (order_id, ticket_id, quantity) VALUES (:order_id, :ticket_id, :quantity)");
        $stmt->bindParam(':order_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':ticket_id', $ticketId, PDO::PARAM_INT);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return $this->connection->lastInsertId();
        } else {
            return false;
        }
    }
    public function getAllOrdersByUserId($userId) {
        try {
            $stmt = $this->connection->prepare("SELECT orderitem.quantity, testticket.ticket_type, testticket.price
                                            FROM orderitem
                                            JOIN testticket ON testticket.id = orderitem.ticket_id
                                            JOIN `order` ON `order`.orderId = orderitem.order_id
                                            WHERE `order`.user_id = :user_id");
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            $dbRow = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $orderItems = array();
            foreach ($dbRow as $row) {
                $orderItems[] = $this->createOrderItemObject($row);
            }
            return $orderItems;

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    private function createOrderItemObject($row)
    {
        $orderItem = new OrderItem();
        $orderItem->setQuantity($row['quantity']);
        $orderItem->setTicketType($row['ticket_type']);
        $orderItem->setPrice($row['price']);
        return $orderItem;
    }



}