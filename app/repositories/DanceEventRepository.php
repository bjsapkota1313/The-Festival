<?php
require_once __DIR__ . '/../models/DanceEvent/DanceEvent.php';
require_once __DIR__ . '/EventRepository.php';
require_once __DIR__ . '/../services/ArtistService.php';

class DanceEventRepository extends EventRepository
{
    private ArtistService $artistService;

    public function __construct()
    {
        parent::__construct();
        $this->artistService = new ArtistService();
    }

    public function getDanceEventByEventId($eventId): ?DanceEvent
    {
        $query = "SELECT event.eventId,event.eventName FROM event WHERE eventId = :eventId";
        $result = $this->executeQuery($query, array(':eventId' => $eventId), false);
        if (!empty($result)) {
            return $this->createDanceEventInstance($result);
        }
        return null;
    }

    private function createArtistPerformanceInstance($dbRow): ArtistPerformance
    {
        try {
            $artistPerformance = new ArtistPerformance();
            $artistPerformance->setArtistPerformanceId($dbRow['artistPerformanceId']);
            $artistPerformance->setArtists($this->getAllParticipatingArtistsBYArtistPerformance($dbRow['artistPerformanceId']));
            $dateTime = $dbRow['date'] . '' . $dbRow['time'];
            $artistPerformance->setDate(new DateTime($dateTime));
            $artistPerformance->setSession($dbRow['sessionName']);
            $artistPerformance->setVenue($this->getLocationById($dbRow['venueId']));
            $artistPerformance->setDuration(90.00); //ToDO: get duration from database
            return $artistPerformance;
        } catch (Exception $e) {
            echo "Error while creating artist performance instance: " . $e->getMessage();
        }

    }

    private function createDanceEventInstance($dbRow): DanceEvent
    {
        try {
            $danceEvent = new DanceEvent();
            $danceEvent->setEventId($dbRow['eventId']);
            $danceEvent->setEventName($dbRow['eventName']);
            $danceEvent->setArtistPerformances($this->getArtistPerformancesByEventId($dbRow['eventId']));
            return $danceEvent;
        } catch (Exception $e) {
            echo "Error while creating dance event instance: " . $e->getMessage();
        }
    }

    private function getAllParticipatingArtistsBYArtistPerformance($artistPerformanceId): ?array
    {
        $query = "SELECT artistId FROM participatingArtist WHERE artistPerformanceId = :artistPerformanceId";
        $result = $this->executeQuery($query, array(':artistPerformanceId' => $artistPerformanceId));
        if (empty($result)) {
            return null;
        }
        $artists = array();
        foreach ($result as $row) {
            $artists[] = $this->artistService->getArtistByArtistID($row['artistId']);
        }
        return $artists;
    }

    public function getArtistPerformancesByEventId($eventId): ?array
    {
        $query = "SELECT artistperformance.artistPerformanceId,artistPerformance.venueId,timetable.time,eventDate.date,artistperformancesession.sessionName
                                                FROM artistPerformance
                                                join artistperformancesession on artistperformancesession.artistperformancesessionId=artistPerformance.sessionId
                                                 join timetable on artistPerformance.timetableId = timetable.timetableId
                                                join eventdate on timetable.eventDateId = eventdate.eventDateId
                                                WHERE eventID= :eventId
                                                ORDER BY eventdate.date ASC,timetable.time ASC";
                        $result = $this->executeQuery($query, array(':eventId'=> $eventId));
        if (empty($result)) {
            return null;
        }
        $artistPerformances = array();
        foreach ($result as $row) {
            $artistPerformances[] = $this->createArtistPerformanceInstance($row);
        }
        return $artistPerformances;

    }

    public function getAllArtistPerformancesDoneByArtistIdAtEvent($artistId, $eventName): ?array
    {

        $query = "SELECT artistperformance.artistPerformanceId,artistPerformance.venueId,timetable.time,eventDate.date,artistperformancesession.sessionName
            FROM artistPerformance
            join artistperformancesession on artistperformancesession.artistperformancesessionId=artistPerformance.sessionId
            join timetable on artistPerformance.timetableId = timetable.timetableId
            join eventdate on timetable.eventDateId = eventdate.eventDateId
            join participatingartist on participatingartist.artistPerformanceId = artistPerformance.artistPerformanceId
            join event on event.eventId = artistPerformance.eventId
            WHERE participatingartist.artistId = :artistId AND event.eventName = :eventName
            ORDER BY eventdate.date ASC,timetable.time ASC";
        $result = $this->executeQuery($query, array(':artistId' => $artistId, ':eventName' => $eventName));
        if (empty($result)) {
            return null;
        }
        $artistPerformances = array();
        foreach ($result as $row) {
            $artistPerformances[] = $this->createArtistPerformanceInstance($row);
        }
        return $artistPerformances;
    }

}