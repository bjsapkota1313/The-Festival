<?php
require_once __DIR__ . '/../repositories/DanceEventRepository.php';
require_once __DIR__ .'/../models/Exceptions/DatabaseQueryException.php';
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

    /**
     * @throws DatabaseQueryException
     */
    public function deleteVenue($venueId): bool
    { // checking if the venue is used by a performance or not if yes it cannot be deleted
        if($this->danceRepo->isPerformanceVenue($venueId)){
            throw new DatabaseQueryException("Venue is used by a performance so it cannot be deleted at the moment");
        }
       return  $this->danceRepo->deleteVenue($venueId);
    }
}