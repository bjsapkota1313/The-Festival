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
        $stmt = $this->connection->prepare("SELECT historytourticket.id
                                        FROM historytour
                                        JOIN language ON language.languageId = historytour.languageId
                                        JOIN timetable ON timetable.timeTableId = historytour.timeTableId
                                        JOIN historytourticket ON historytourticket.historyTourId = historytour.historyTourId
                                        JOIN eventdate ON eventdate.eventDateId = timetable.eventDateId
                                        WHERE language.name = :name
                                        AND historytourticket.ticket_type = :ticket_type
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
        $stmt = $this->connection->prepare("INSERT INTO orderitem (order_id, historyTourTicketId, quantity) VALUES (:order_id, :historyTourTicketId, :quantity)");
        $stmt->bindParam(':order_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':historyTourTicketId', $ticketId, PDO::PARAM_INT);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return $this->connection->lastInsertId();
        } else {
            return false;
        }
    }
    public function getHistoryTourOrdersByUserId($userId) {
        try {
            $stmt = $this->connection->prepare("SELECT orderItem.orderItemId, orderitem.quantity, historytourticket.ticket_type, historytourticket.price, language.name
                                            FROM orderitem
                                            JOIN historytourticket ON historytourticket.id = orderitem.historyTourTicketId
                                            JOIN `order` ON `order`.orderId = orderitem.order_id
                                            JOIN historytour on historytour.historyTourId = historytourticket.historyTourId
                                            JOIN language on  language.languageId = historytour.languageId
                                            WHERE `order`.user_id = :user_id");
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            $dbRow = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $orderItems = array();
            foreach ($dbRow as $row) {
                $orderItems[] = $this->createHistoryOrderItemObject($row);
            }
            return $orderItems;

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    private function createHistoryOrderItemObject($row)
    {
        $orderItem = new OrderItem();
        $orderItem->setOrderItemId($row['orderItemId']);
        $orderItem->setQuantity($row['quantity']);
        $orderItem->setTicketType($row['ticket_type']);
        $orderItem->setPrice($row['price']);
        $orderItem->setLanguage($row['name']);
        return $orderItem;
    }
    public function getRestaurantOrdersByUserId($userId) {
        try {
            $stmt = $this->connection->prepare("SELECT orderItem.orderItemId, orderitem.quantity, restaurant.name, restaurant.foodTypes, restaurantticket.ticketType, restaurantticket.price
                                            FROM orderitem
                                            JOIN restaurantticket ON restaurantticket.restaurantTicketId = orderitem.restaurantTicketId
                                            JOIN `order` ON `order`.orderId = orderitem.order_id
                                            JOIN restaurant on restaurant.id = restaurantticket.restaurantId
                                            WHERE `order`.user_id = :user_id;");
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            $dbRow = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $orderItems = array();
            foreach ($dbRow as $row) {
                $orderItems[] = $this->createRestaurantOrderItemObject($row);
            }
            return $orderItems;

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    private function createRestaurantOrderItemObject($row)
    {
        $orderItem = new OrderItem();
        $orderItem->setOrderItemId($row['orderItemId']);
        $orderItem->setQuantity($row['quantity']);
        $orderItem->setTicketType($row['ticketType']);
        $orderItem->setPrice($row['price']);
        $orderItem->setRestaurantName($row['name']);
        $orderItem->setFoodType($row['foodTypes']);
        return $orderItem;
    }
    public function getOrderItemIdByTicketId($ticketId){
        try {
            $stmt = $this->connection->prepare("SELECT orderItemId FROM orderitem WHERE historyTourTicketId = :historyTourTicketId;");
            $stmt->bindValue(':historyTourTicketId', $ticketId);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['orderItemId'];

        } catch (PDOException $e) {
            // Handle the exception here
            // For example, you could log the error message and return null
            error_log("Error fetching order for user ID $userId: " . $e->getMessage());
            return null;
        }
    }
    public function updateOrderItemByTicketId($ticketId, $quantity){
        try {
            $stmt = $this->connection->prepare("UPDATE orderItem SET quantity = quantity + :quantity WHERE historyTourTicketId = :historyTourTicketId");
            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':historyTourTicketId', $ticketId);
            $stmt->execute();
        } catch (PDOException $e) {
            // Handle the error
            echo "Error updating order item: " . $e->getMessage();
        }
    }
    public function updateQuantity($orderItemId, $quantity) {
        try {
            $stmt = $this->connection->prepare("UPDATE orderitem SET quantity = :quantity WHERE orderItemId = :orderItemId");
            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':orderItemId', $orderItemId);

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            // Handle any exceptions or errors that occurred during the update
            error_log("Error updating quantity: " . $e->getMessage());
            return false;
        }
    }
    public function deleteOrderItem($orderItemId) {
        try {
            // Prepare the SQL query
            $stmt = $this->connection->prepare('DELETE FROM orderitem WHERE orderItemId = :orderItemId');

            // Bind the parameters
            $stmt->bindParam(':orderItemId', $orderItemId);

            // Execute the query
            $stmt->execute();

        }
        catch(PDOException $e) {
            // Handle the exception here
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

}

//SELECT orderItem.orderItemId, orderitem.quantity, restaurant.name, restaurant.foodTypes
//                                            FROM orderitem
//                                            JOIN restaurantticket ON restaurantticket.restaurantTicketId = orderitem.restaurantTicketId
//                                            JOIN `order` ON `order`.orderId = orderitem.order_id
//                                            JOIN restaurant on restaurant.id = restaurantticket.restaurantId
//                                            WHERE `order`.user_id = '104';