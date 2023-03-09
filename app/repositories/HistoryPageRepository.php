<?php
require_once __DIR__ . '/../Models/HistoryTourLocation.php';
require_once __DIR__ . '/../Models/historyTimeTable.php';

class HistoryPageRepository extends Repository
{
    public function getGoogleMarkerByLocationName(string $locationName, $locationPostCode)
    {
        try {
            $stmt = $this->connection->prepare("SELECT streetName, houseNumber, houseNumberAdditional, postCode FROM Page WHERE locationName = :locationName AND postCode = :postCode");
            $stmt->bindParam(':locationName', $locationName);
            $stmt->bindParam(':postCode', $locationPostCode);

            $stmt->execute();
            if ($stmt->rowCount() == 0) {
                return null;
            }
            $result = $stmt->fetch();
            return $result;

//            return $this->createPageInstance($result);
        } catch (PDOException|Exception $e) {
            echo $e;
        }
    }

    public function getAllHistoryTourLocation()
    {
        $stmt = $this->connection->prepare("SELECT location.locationName, location.postCode, historytourlocation.historyTourLocationId
                                            FROM historytourlocation
                                            INNER JOIN location ON location.locationId=historytourlocation.locationId");
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $dbRow) {
            $historyLocations[] = $this->createHistoryTourLocation($dbRow);
        }

        return $historyLocations;
    }

    public function getTourDate()
    {
        $stmt = $this->connection->prepare("SELECT location.locationName, location.postCode, historytourlocation.historyTourLocationId
                                            FROM historytourlocation
                                            INNER JOIN location ON location.locationId=historytourlocation.locationId");
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $dbRow) {
            $historyLocations[] = $this->createHistoryTourLocation($dbRow);
        }

        return $historyLocations;
    }

    private function createHistoryTourLocation($result): HistoryTourLocation
    {
        $historyTourLocation = new HistoryTourLocation();
        $historyTourLocation->setLocationName($result['locationName']);
        $historyTourLocation->setPostCode($result['postCode']);
        return $historyTourLocation;
    }

    public function getHistoryTourTimeTable()
    {
        $stmt = $this->connection->prepare("SELECT eventDate.date, language.name, timetable.time
                                                    FROM eventdate
                                                    INNER JOIN timetable ON eventdate.eventDateId = timetable.eventDateId
                                                    INNER JOIN historytour ON historytour.timeTableId = timetable.timeTableId
                                                    INNER JOIN language ON language.languageId = historytour.languageId;");
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $dbRow) {
            $historyTourTimeTables[] = $this->createHistoryTourTimeTable($dbRow);
        }

        return $historyTourTimeTables;
    }

    /**
     * @throws Exception
     */
    private function createHistoryTourTimeTable($result): historyTimeTable
    {
//        $historyTourTimeTables = new historyTimeTable();
//        $previousDate = null;
//        $eventDate = null;
//
//        foreach ($historyTourTimeTables as $historyTourTimeTable) {
//            if ($eventDate === null) {
//                // Set the date property of the first historyTimeTable object
//                $eventDate = new eventDate();
//                $eventDate->setDate($historyTourTimeTable->getDate());
//                $historyTourTimeTable->setDate($eventDate);
//                $previousDate = $eventDate;
//            } else if ($historyTourTimeTable->getDate() !== $previousDate->getDate()) {
//                // Create a new historyTimeTable object if the date has changed
//                $eventDate = new eventDate();
//                $eventDate->setDate($historyTourTimeTable->getDate());
//                $historyTourTimeTable = new historyTimeTable();
//                $historyTourTimeTable->setDate($eventDate);
//                $previousDate = $eventDate;
//            }
//        }
//        return $historyTourTimeTables;
//        static $lastDate; // Static variable to store the last date
//
//        $eventDate = new eventDate();
//        $eventDate->setDate($result['date']);
//
//        if ($lastDate !== $eventDate) {
//            // Create a new historyTimeTable object if the date has changed
//            $historyTourTimeTable = new historyTimeTable();
//            $historyTourTimeTable->setDate($eventDate);
//            $lastDate = $eventDate;
//        } else {
//            // Otherwise, use the previously created object
//            $historyTourTimeTable = end($historyTourTimeTables);
//        }
//
//        return $historyTourTimeTable;
//        $historyTourTimeTable = new historyTimeTable();
//        $eventDate = new eventDate();
//        $eventDate->setDate($result['date']);
//
//        foreach ($eventDate as $date){
//            $historyTourTimeTable->setDate($date);
//            break; // stop looping after the first date is retrieved
//        }
//
//        return $historyTourTimeTable;

        $historyTourTimeTable = new historyTimeTable();
        $dateString = $result['date'];
        $dateObject = new DateTime($dateString);
        $historyTourTimeTable->setDate($dateObject);
        return $historyTourTimeTable;

//        $historyTourTimeTable = new historyTimeTable();
//        $eventDate = new eventDate();
//        $eventDate->setDate($result['date']);
//
//        $previousDate = null; // set the default value to null
//
//        if ($eventDate->getDate() !== $previousDate) {
//            $historyTourTimeTable->setDate($eventDate);
//            $previousDate = $eventDate->getDate(); // update the previous date
//        }
//
//        return $historyTourTimeTable;
    }

    public function getHistoryTourLanguage()
    {
        $stmt = $this->connection->prepare("SELECT language.name
                                                    FROM historytour
                                                    INNER JOIN historytour ON historytour.timeTableId = timetable.timeTableId
                                                    INNER JOIN language ON language.languageId = historytour.languageId;");
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $dbRow) {
            $historyTourTimeTables[] = $this->createHistoryTourTimeTable($dbRow);
        }

        return $historyTourTimeTables;
    }
    private function createHistoryTourLanguageTable($result){

    }

}


//SELECT eventDate.date, language.name, timetable.time
//FROM eventdate
//INNER JOIN timetable ON eventdate.eventDateId = timetable.eventDateId
//INNER JOIN historytour ON historytour.timeTableId = timetable.timeTableId
//INNER JOIN language ON language.languageId = historytour.languageId;


