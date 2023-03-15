<?php
require_once __DIR__ . '/repository.php';
require_once __DIR__ . '/../models/AvailableEvent.php';

class AvailableEventRepository extends repository
{
    public function getAvailableEventsByEventType($type)
    {
        try {
            $stmt = $this->connection->prepare("SELECT  eventName, eventDate, eventHour, deliveryPossibilities FROM availableevent WHERE eventType = :type");
            $stmt->bindParam(':type', $type);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, 'AvailableEvent');
            
        } catch (PDOException $e) {
            echo $e;
        }
    }

}