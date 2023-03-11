<?php
require_once __DIR__ . '/../models/DanceEvent/DanceEvent.php';
require_once __DIR__ . '/EventRepository.php';
require_once __DIR__ . '/../services/ArtistService.php';

class DanceEventRepository extends EventRepository
{
    private $artistService;

    public function __construct()
    {
        parent::__construct();
        $this->artistService = new ArtistService();
    }

    public function getDanceEventByEventId($eventId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT event.eventId,event.eventName FROM event WHERE eventId = :eventId");
            $stmt->bindParam(':eventId', $eventId);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $dbRow = $stmt->fetch();
            return $this->createDanceEventInstance($dbRow);
        } catch (PDOException $e) {
            echo $e;
        }
    }

    /**
     * @throws Exception
     */
    private function createArtistPerformanceInstance($dbRow): ArtistPerformance
    {
        $artistPerformance = new ArtistPerformance();
        $artistPerformance->setArtistPerformanceId($dbRow['artistPerformanceId']);
        $artistPerformance->setArtists($this->getAllParticipatingArtistsBYArtistPerformance($dbRow['artistPerformanceId']));
        $dateTime = $dbRow['date'] . '' . $dbRow['time'];
        $artistPerformance->setDate(new DateTime($dateTime));
        $artistPerformance->setSession($dbRow['sessionName']);
        $artistPerformance->setVenue($this->getLocationById($dbRow['venueId']));
        $artistPerformance->setDuration(90.00); //ToDO: get duration from database
        return $artistPerformance;
    }

    private function createDanceEventInstance($dbRow)
    {
        $danceEvent = new DanceEvent();
        $danceEvent->setEventId($dbRow['eventId']);
        $danceEvent->setEventName($dbRow['eventName']);
        $danceEvent->setArtistPerformances($this->getArtistPerformancesByEventIdId($dbRow['eventId']));
        return $danceEvent;
    }

    public function getArtistPerformancesByEventIdId($eventId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT artistperformance.artistPerformanceId,artistPerformance.venueId,timetable.time,eventDate.date,artistperformancesession.sessionName
                                                    FROM artistPerformance
                                                    join artistperformancesession on artistperformancesession.artistperformancesessionId=artistPerformance.sessionId
                                                     join timetable on artistPerformance.timetableId = timetable.timetableId
                                                    join eventdate on timetable.eventDateId = eventdate.eventDateId
                                                    WHERE eventID= :eventId
                                                    ORDER BY eventdate.date ASC,timetable.time ASC");
            $stmt->bindParam(':eventId', $eventId);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();
            $artistPerformances = array();
            foreach ($result as $row) {
                $artistPerformances[] = $this->createArtistPerformanceInstance($row);
            }
            return $artistPerformances;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    private function getAllParticipatingArtistsBYArtistPerformance($artistPerformanceId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT artistId FROM participatingArtist WHERE artistPerformanceId = :artistPerformanceId");
            $stmt->bindParam(':artistPerformanceId', $artistPerformanceId);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();
            $artists = array();
            foreach ($result as $row) {
                $artists[] = $this->artistService->getArtistByArtistID($row['artistId']);
            }
            return $artists;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function getAllArtistPerformancesDoneByArtistIdAtEvent($artistId, $eventName)
    {
        try {
            $stmt = $this->connection->prepare("SELECT artistperformance.artistPerformanceId,artistPerformance.venueId,timetable.time,eventDate.date,artistperformancesession.sessionName
            FROM artistPerformance
         join artistperformancesession on artistperformancesession.artistperformancesessionId=artistPerformance.sessionId
         join timetable on artistPerformance.timetableId = timetable.timetableId
         join eventdate on timetable.eventDateId = eventdate.eventDateId
         join participatingartist on participatingartist.artistPerformanceId = artistPerformance.artistPerformanceId
         join event on event.eventId = artistPerformance.eventId
            WHERE participatingartist.artistId = :artistId AND event.eventName = :eventName
            ORDER BY eventdate.date ASC,timetable.time ASC");

            $stmt->bindParam(':artistId', $artistId);
            $stmt->bindParam(':eventName', $eventName);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();
            $artistPerformances = array();
            foreach ($result as $row) {
                $artistPerformances[] = $this->createArtistPerformanceInstance($row);
            }
            return $artistPerformances;
        } catch (PDOException|Exception $e) {
            echo $e;
        }
    }

}