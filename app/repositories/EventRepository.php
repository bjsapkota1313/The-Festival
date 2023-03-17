<?php
require_once __DIR__ . '/repository.php';
require_once __DIR__ . '/../services/DanceEventService.php';
require_once __DIR__ . '/../services/HistoryService.php';
require_once __DIR__ . '/HistoryEventRepository.php';
require_once __DIR__ . '/../models/Exceptions/DatabaseQueryException.php';

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

            case 'A Stroll Through History':
                $service = new HistoryService();
                return $service->getHistoryEventByEventId($eventId);
        }
    }

    private function getAllEventsName()
    {

        try {
            $stmt = $this->connection->prepare("SELECT eventName FROM event");
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo $e;
        }
    }

    protected function getLocationById($locationId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT location.locationId,location.locationName, location.postCode, location.streetName, location.houseNumber, location.houseNumberAdditional
                                                    FROM location WHERE location.locationId = :locationId");
            $stmt->bindParam(':locationId', $locationId);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Location');
            return $stmt->fetch();
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function getAllLocations()
    {
        try {
            $stmt = $this->connection->prepare("SELECT location.locationId,location.locationName, location.postCode, location.streetName, location.houseNumber, location.houseNumberAdditional
                                                    FROM location");
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Location');
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo $e;
        }
    }

    //checks if the date exist or not if exi

    /**
     * @throws DatabaseQueryException
     */
    private function getEventDateIdByInsertingDate($date)
    {
        $query = "SELECT eventDateId FROM EventDate WHERE date = :date";
        $result = $this->executeQuery($query, array(':date' => $date), false); // date exist it is going to return us date
        if (empty($result)) {
            $query = "INSERT INTO EventDate (date) VALUES (:date)";
            $executedResult = $this->executeQuery($query, array(':date' => $date), false, true);
            if (is_bool($executedResult)) { // if it is bools means that it was not inserted into the database
                throw new DatabaseQueryException("Error while inserting date into database");
            }
            return $executedResult; // it is going to return us the id of the date that we just inserted
        }
        return $result['eventDateId']; // returns the id of the Event Date
    }

    /**
     * @throws DatabaseQueryException
     */
    private function getTimetableIDByInsertingTimeWithDateId($time, $eventDateId)
    {
        $query = "SELECT timeTableId FROM timetable WHERE time = :time ";
        $result = $this->executeQuery($query, array(':time' => $time), false);
        if (empty($result)) {
            $query = "INSERT INTO timetable (time,eventDateId) VALUES (:time,:eventDateId)";
            $executedResult = $this->executeQuery($query, array(':time' => $time, ':eventDateId' => $eventDateId), false, true);
            if (is_bool($executedResult)) { // if it is bools means that it was not inserted into the database
                throw new DatabaseQueryException("Error while inserting time into database");
            }
            return $executedResult; // it is going to return us the id of the date that we just inserted
        }
        return $result['timeTableId']; // returns the id of the timetable
    }

    /**
     * @throws DatabaseQueryException
     */
    protected function getTimetableIdByDateAndTime($date, $time)
    {
        $eventDateId = $this->getEventDateIdByInsertingDate($date);
        return $this->getTimetableIDByInsertingTimeWithDateId($time, $eventDateId);
    }

}