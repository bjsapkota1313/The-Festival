<?php
require_once __DIR__ . '/../Models/HistoryTourLocation.php';

class HistoryPageRepository extends Repository
{
    public function getGoogleMarkerByLocationName(string $locationName,$locationPostCode)
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
    public function getAllHistoryTourLocation(){
        $stmt = $this->connection->prepare("SELECT location.locationName, location.postCode, historytourlocation.historyTourLocationId
                                            FROM historytourlocation
                                            INNER JOIN location ON location.locationId=historytourlocation.locationId");
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $dbRow){
            $historyLocations[]=$this->createHistoryTourLocation($dbRow);
        }

        return $historyLocations;
    }
    public function getTourDate(){
        $stmt = $this->connection->prepare("SELECT location.locationName, location.postCode, historytourlocation.historyTourLocationId
                                            FROM historytourlocation
                                            INNER JOIN location ON location.locationId=historytourlocation.locationId");
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $dbRow){
            $historyLocations[]=$this->createHistoryTourLocation($dbRow);
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
}

//SELECT DISTINCT eventDate.date, eventDate.day
//FROM eventdate
//INNER JOIN timetable ON eventdate.eventDateId = timetable.eventDateId;
