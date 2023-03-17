<?php
require_once __DIR__.'/EventRepository.php';
require_once __DIR__.'/../models/DanceEvent/Performance.php';
require_once __DIR__.'/../models/DanceEvent/PerformanceSession.php';
require_once __DIR__.'/../services/ArtistService.php';
class PerformanceRepository extends EventRepository
{
    private ArtistService $artistService;
    public function __construct()
    {
        parent::__construct();
        $this->artistService = new ArtistService();
    }
    public function getPerformancesByEventId($eventId): ?array
    {
        $query = "SELECT Performance.PerformanceId,Performance.venueId,timetable.time,eventDate.date,performance.sessionId,Performance.duration
                    FROM Performance
                join timetable on Performance.timetableId = timetable.timetableId
                join eventdate on timetable.eventDateId = eventdate.eventDateId
                WHERE performance.eventID = :eventId
                ORDER BY eventdate.date ASC,timetable.time ASC";
        $result = $this->executeQuery($query, array(':eventId'=> $eventId));
        if (empty($result)) {
            return null;
        }
        $artistPerformances = array();
        foreach ($result as $row) {
            $artistPerformances[] = $this->createPerformanceInstance($row);
        }
        return $artistPerformances;

    }
    private function createPerformanceInstance($dbRow): Performance
    {
        try {
            $performance = new Performance();
            $performance->setPerformanceId($dbRow['PerformanceId']);
            $performance->setArtists($this->artistService->getAllParticipatingArtistsInPerformance($dbRow['PerformanceId']));
            $dateTime = $dbRow['date'] . '' . $dbRow['time'];
            $performance->setDate(new DateTime($dateTime));
            $performance->setSession($this->getPerformanceSessionById($dbRow['sessionId']));
            $performance->setVenue($this->getLocationById($dbRow['venueId']));
            $performance->setDuration($dbRow['duration']);
            return $performance;
        } catch (Exception $e) {
            echo "Error while creating artist performance instance: " . $e->getMessage();
        }

    }
    public function getAllPerformancesDoneByArtistIdAtEvent($artistId, $eventName): ?array
    {

        $query = "SELECT Performance.PerformanceId,Performance.venueId,timetable.time,eventDate.date,performance.sessionId,performance.duration
            FROM Performance
            join timetable on Performance.timetableId = timetable.timetableId
            join eventdate on timetable.eventDateId = eventdate.eventDateId
            join participatingartist on participatingartist.PerformanceId = Performance.PerformanceId
            join event on event.eventId = Performance.eventId
            WHERE participatingartist.artistId = :artistId AND event.eventName = :eventName
            ORDER BY eventdate.date ASC,timetable.time ASC";
        $result = $this->executeQuery($query, array(':artistId' => $artistId, ':eventName' => $eventName));
        if (empty($result)) {
            return null;
        }
        $artistPerformances = array();
        foreach ($result as $row) {
            $artistPerformances[] = $this->createPerformanceInstance($row);
        }
        return $artistPerformances;
    }
    public function getAllPerformanceSessions(){
        try{
            $stmt = $this->connection->prepare("SELECT PerformanceSessionId,sessionName,sessionDescription FROM performancesession");
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'PerformanceSession');
            return $stmt->fetchAll();
        }
        catch(PDOException $e){
            echo "Error while getting all artist performance sessions: ".$e->getMessage();
        }
    }
    public function getPerformanceSessionById($performanceSessionId){
        try{
            $stmt = $this->connection->prepare("SELECT PerformanceSessionId,sessionName,sessionDescription FROM performancesession WHERE PerformanceSessionId = :performanceSessionId");
            $stmt->execute(array(':performanceSessionId'=>$performanceSessionId));
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'PerformanceSession');
            return $stmt->fetch();
        }
        catch(PDOException $e){
            echo "Error while getting artist performance session by id: ".$e->getMessage();
        }
    }


}