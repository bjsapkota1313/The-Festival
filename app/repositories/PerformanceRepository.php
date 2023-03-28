<?php
require_once __DIR__ . '/../models/DanceEvent/Performance.php';
require_once __DIR__ . '/../models/DanceEvent/PerformanceSession.php';
require_once __DIR__ . '/EventRepository.php';
require_once __DIR__ . '/../services/ArtistService.php';
require_once __DIR__ . '/../models/Exceptions/DatabaseQueryException.php';

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
        $result = $this->executeQuery($query, array(':eventId' => $eventId));
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

    public function getPerformanceSessionById($performanceSessionId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT performanceSessionId ,sessionName,sessionDescription FROM performancesession WHERE performanceSessionId = :performanceSessionId");
            $stmt->execute(array(':performanceSessionId' => $performanceSessionId));
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'PerformanceSession');
            return $stmt->fetch();
        } catch (PDOException $e) {
            echo "Error while getting artist performance session by id: " . $e->getMessage();
        }
    }

    public function getAllPerformanceSessions()
    {
        try {
            $stmt = $this->connection->prepare("SELECT performanceSessionId ,sessionName,sessionDescription FROM performancesession");
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'PerformanceSession');
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Error while getting all artist performance sessions: " . $e->getMessage();
        }
    }

    /**
     * @throws DatabaseQueryException
     */
    public function addPerformanceWithEventId($eventId, $data): bool
    {
        $query = "INSERT INTO Performance (eventId,venueId,timetableId,sessionId,duration) VALUES (:eventId,:venueId,:timetableId,:sessionId,:duration)";
        $timetableID = $this->getTimetableIdByDateAndTime($data['performanceDate'], $data['startTime']);
        $parameters = array(':eventId' => $eventId, ':venueId' => $data['Venue'], ':timetableId' => $timetableID, ':sessionId' => $data['performanceSession'], ':duration' => $data['duration']);
        $performanceID = $this->executeQuery($query, $parameters, false, true);
        if (!is_numeric($performanceID)) {
            throw new DatabaseQueryException("Error while inserting performance in Database");
        }
        foreach ($data['artists'] as $artistId) {
            if (!$this->insertParticipatingArtists($artistId, $performanceID)) {
                throw new DatabaseQueryException("Error while inserting participating artists, bUt you can always Edit thea participating artists later.");
            }
        }
        return true;
    }

    public function insertParticipatingArtists($artistId, $performanceId)
    {
        $query = "INSERT INTO participatingartist (artistId,performanceId) VALUES (:artistId,:performanceId)";
        $parameters = array(':artistId' => $artistId, ':performanceId' => $performanceId);
        return $this->executeQuery($query, $parameters); // it returns bool value
    }

    public function deletePerformance($performanceId)
    {
        $query = "DELETE FROM Performance WHERE performanceId = :performanceId";
        $parameters = array(':performanceId' => $performanceId);
        return $this->executeQuery($query, $parameters);
    }

    public function isLocationAvailableAtTime($locationId, $date, $time): bool
    {
        $query = "SELECT performance.performanceId
                  FROM performance
                  JOIN timetable on performance.timeTableId = timeTable.timeTableId
                  JOIN eventDate on timeTable.eventDateId = eventDate.eventDateId
                  WHERE performance.venueId = :locationId AND eventDate.date = :date AND
                  :startTime <= DATE_ADD(timetable.time, INTERVAL performance.duration MINUTE)";
        $parameters = array(':locationId' => $locationId, ':date' => $date, ':startTime' => $time);
        $result = $this->executeQuery($query, $parameters);

        if (empty($result)) {
            return true;
        }
        return false;
    }

    public function getVenueById($locationId): ?Location
    {
        return $this->getLocationById($locationId);
    }


}