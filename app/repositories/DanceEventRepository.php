<?php
require_once __DIR__ . '/../models/DanceEvent/DanceEvent.php';
require_once __DIR__ . '/../services/ArtistService.php';
require_once __DIR__. '/../services/PerformanceService.php';
require_once __DIR__ . '/EventRepository.php';

class DanceEventRepository extends EventRepository
{
    private ArtistService $artistService;
    private PerformanceService $performanceService;

    public function __construct()
    {
        parent::__construct();
        $this->artistService = new ArtistService();
        $this->performanceService = new PerformanceService();
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

    private function createDanceEventInstance($dbRow): DanceEvent
    {
        try {
            $danceEvent = new DanceEvent();
            $danceEvent->setEventId($dbRow['eventId']);
            $danceEvent->setEventName($dbRow['eventName']);
            $danceEvent->setPerformances($this->performanceService->getPerformancesByEventId($dbRow['eventId']));
            $danceEvent->setEventParagraphs($this->getEventParagraphsByEventID($dbRow['eventId']));
            $danceEvent->setEventImages($this->getEventImagesByEventId($dbRow['eventId']));
            return $danceEvent;
        } catch (Exception $e) {
            echo "Error while creating dance event instance: " . $e->getMessage();
        }
    }
}