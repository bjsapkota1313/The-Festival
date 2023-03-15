<?php
require_once __DIR__ . '/../models/HistoryEvent/HistoryEvent.php';
require_once __DIR__ . '/EventRepository.php';

class HistoryEventRepository extends EventRepository
{
    public function getHistoryEventByEventId($eventId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT event.eventId,event.eventName FROM event WHERE eventId = :eventId");
            $stmt->bindParam(':eventId', $eventId);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $dbRow = $stmt->fetch();
            return $this->createHistoryEventInstance($dbRow);
        } catch (PDOException $e) {
            echo $e;
        }
    }

    private function createHistoryEventInstance($dbRow)
    {
        $danceEvent = new HistoryEvent();
        $danceEvent->setEventId($dbRow['eventId']);
        $danceEvent->setEventName($dbRow['eventName']);
        $danceEvent->setHistoryTours($this->getToursByEventId($dbRow['eventId']));
        return $danceEvent;
    }

    public function getToursByEventId($eventId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT eventDate.date, language.name, timetable.time, historytour.eventId, historytour.historyTourId
FROM eventdate
INNER JOIN timetable ON eventdate.eventDateId = timetable.eventDateId
INNER JOIN historytour ON historytour.timeTableId = timetable.timeTableId
INNER JOIN language ON language.languageId = historytour.languageId
WHERE historytour.eventId = :eventId
ORDER BY eventDate.date ASC, timetable.time ASC;");
            $stmt->bindParam(':eventId', $eventId);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();
            $historyTours = array();
            foreach ($result as $row) {
                $historyTours[] = $this->createHistoryTourInstance($row);
            }
            return $historyTours;
        } catch (PDOException $e) {
            echo $e;
        }

    }

    /**
     * @throws Exception
     */
    private function createHistoryTourInstance($dbRow)
    {
        $historyTours = new HistoryTour();
        $historyTours->setHistoryTourId($dbRow['historyTourId']);
        $historyTours->setTourLanguage($dbRow['name']);
        $dateTime = $dbRow['date'] . '' . $dbRow['time'];
        $historyTours->setTourDate(new DateTime($dateTime));
        $timeString = $dbRow['time'];
        $time = DateTime::createFromFormat('H:i:s', $timeString);
        $historyTours->setTime($time);
        $historyTours->setHistoryTourLocations((array)$this->getHistoryTourLocationsByLocationName($dbRow['historyTourId']));
        $historyTours->setDuration(90.00); //ToDO: get duration from database
        return $historyTours;
    }

    public function getHistoryTourLocationsByLocationName($historyTourId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT historyTourLocation.historyTourLocationId, historyTourLocation.locationId, historyTourLocation.locationInformation, historyTourLocation.historyP1, historyTourLocation.historyP2, location.locationName 
        FROM historyTourLocation 
        INNER JOIN location on location.locationId = historyTourLocation.locationId
        where historytourlocation.historytourId = :historyTourId");
            $stmt->bindParam(':historyTourId', $historyTourId);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetch();
            if (!empty($result)) {
                return $this->createHistoryTourLocations($result);
            }
            return null;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function getHistoryTourLocationByLocationId($locationId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT historyTourLocation.historyTourLocationId, historyTourLocation.locationId, historyTourLocation.locationInformation, historyTourLocation.historyP1, historyTourLocation.historyP2, location.locationName 
        FROM historyTourLocation 
        INNER JOIN location on location.locationId = historyTourLocation.locationId
        where location.locationId = :locationId");
            $stmt->bindParam(':locationId', $locationId);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetch();
            if (!empty($result)) {
                return $this->createHistoryTourLocations($result);
            }
            return null;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    private function createHistoryTourLocations($row)
    {
        $historyTourLocations = new HistoryTourLocation();
        $historyTourLocations->setLocationName($row['locationName']);
        $historyTourLocations->setHistoryTourLocationId($row['historyTourLocationId']);
        $historyTourLocations->setTourLocation($this->getLocationById($row['historyTourLocationId']));
        $historyTourLocations->setLocationInfo($row['locationInformation']);
        $historyTourLocations->setHistoryP1($row['historyP1']);
        $historyTourLocations->setHistoryP2($row['historyP2']);
        $historyTourLocations->setTourImage($this->getHistoryTourLocationImagesByHistoryTourLocationId($row['historyTourLocationId']));
        return $historyTourLocations;
    }
    public function test($historyTourLocationId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT historytourimage.historyTourLocationId, historytourimage.imageId, historytourimage.tourLocationImage, image.imageName
                                                    FROM historytourimage
                                                    JOIN image ON image.imageId = historytourimage.imageId where  historytourimage.historyTourLocationId = :historyTourLocationId;");
            $stmt->bindParam(':historyTourLocationId', $historyTourLocationId);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();
            if (!empty($result)) {
                return $this->getImagesWithKeyValue($result);
            }
            return null;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function getHistoryTourLocationImagesByHistoryTourLocationId($historyTourLocationId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT historytourimage.historyTourLocationId, historytourimage.imageId, historytourimage.tourLocationImage, image.imageName
                                                    FROM historytourimage
                                                    JOIN image ON image.imageId = historytourimage.imageId where  historytourimage.historyTourLocationId = :historyTourLocationId;");
            $stmt->bindParam(':historyTourLocationId', $historyTourLocationId);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();
            if (!empty($result)) {
                return $this->getImagesWithKeyValue($result);
            }
            return null;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    private function getImagesWithKeyValue($result): array
    {
        $images = array();
        foreach ($result as $imageRow) {
            $imageName = $imageRow['imageName'];
            $imageSpec = $imageRow['tourLocationImage'];
            if (isset($images[$imageSpec])) { // storing images as key value pair in array
                $images[$imageSpec][] = $imageName;
            } else {
                $images[$imageSpec] = array($imageName);
            }
        }
        return $images;
    }

    private function createHistoryTourImage($row)
    {
        $historyTourImage = new HistoryTourImage();
        $historyTourImage->setHistoryTourLocationId($row['historyTourLocationId']);
        $historyTourImage->setImageName($row['imageName']);
        $historyTourImage->setTourLocationImage($row['tourLocationImage']);

        return $historyTourImage;
    }

}