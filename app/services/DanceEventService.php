<?php
require_once __DIR__ . '/../repositories/DanceEventRepository.php';
class DanceEventService
{
   private  $danceRepo;
    public function __construct()
    {
         $this->danceRepo = new DanceEventRepository();
    }
    public function getAllArtistPerformancesDoneByArtistIdAtEvent($artistId, $eventName): ?array
    {
        return $this->danceRepo->getAllArtistPerformancesDoneByArtistIdAtEvent($artistId, $eventName);
    }
    public function  getDanceEventByEventId($eventId): ?Event
    {
        return $this->danceRepo->getDanceEventByEventId($eventId);
    }
}