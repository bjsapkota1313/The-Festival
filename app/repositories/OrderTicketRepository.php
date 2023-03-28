<?php
require_once __DIR__ . '/repository.php';
require_once __DIR__ . '/../models/OrderTicket.php';


class OrderTicketRepository extends repository
{


    public function getAll()
    {

        try {

            $stmt = $this->connection->prepare("SELECT * FROM orderticket");

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_CLASS, 'OrderTicket');

        } catch (PDOException $e) {
            echo $e;
        }
    }
    private function checkTicketExistence($stmt): bool
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

    public function getTicketById($id)
    {
        try {

            $stmt = $this->connection->prepare("SELECT * From orderticket WHERE orderticketId LIKE :id");
            $stmt->bindValue(':id', $id);
            if ($this->checkTicketExistence($stmt)) {
                $stmt->execute();
                $result = $stmt->fetch();
                return $result;

            }

        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function retrievePreviousTicket()
    {
        try {

            $tickets = $this->getAll();
            $previousTicket = end($tickets);
            return $previousTicket;

        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function retrievePreviousTicketId()
    {
         $ticketService = new OrderTicketService();
         $previousTicket = $ticketService->retrievePreviousTicket();
        if ($previousTicket != NULL) {
            $previousTicketId = $previousTicket->getOrderTicketId();
        } else {
            $previousTicketId = 0;
        }
        return $previousTicketId;
    }



  public function addTicket($id, $availableEventId, $ticketOptions, $orderId)
    {
        $stmt = $this->connection->prepare("INSERT INTO orderticket(orderTicketId, availableEventId, ticketOptions, orderId)VALUES(:orderTicketId, :availableEventId, :ticketOptions, :orderId)");
        $stmt->bindParam(':orderTicketId', $id);
        $stmt->bindParam(':availableEventId', $availableEventId);
        $stmt->bindParam(':ticketOptions', $ticketOptions);
        $stmt->bindParam(':orderId', $orderId);

        $stmt->execute();
    }

}
