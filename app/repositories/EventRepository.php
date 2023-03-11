<?php
require_once __DIR__ . '/repository.php';
require_once __DIR__ . '/../services/DanceEventService.php';
require_once __DIR__ . '/../models/Location.php';
class EventRepository extends repository
{
    public function getEventByName($name)
    {
        try {
            $stmt = $this->connection->prepare("SELECT eventId,eventName FROM event WHERE eventName = :name");
            $stmt->bindParam(':name', $name);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetch();
            return $this->getEventObjectAccordingToEventName($result['eventName'], $result['eventId']);
        } catch (PDOException $e) {
            echo $e;
        }
    }

    private function getEventObjectAccordingToEventName($name, $eventId)
    {
        //Todo: make it dynamic withe the help of the database
        $service = null;
        switch ($name) {

            case 'Dance':
                $service = new DanceEventService();
                return $service->getDanceEventByEventId($eventId);
            case 'History':
                return;
        }
    }
    private function getAllEventsName(){

        try {
            $stmt = $this->connection->prepare("SELECT eventName FROM event");
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function getLocationById($locationId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT location.locationId,location.locationName, location.postCode, location.streetName, location.houseNumber, location.houseNumberAdditional
                                                    FROM location WHERE location.locationId = :locationId");
            $stmt->bindParam(':locationId', $locationId);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Location');
            return  $stmt->fetch();
        } catch (PDOException $e) {
            echo $e;
        }
    }

}