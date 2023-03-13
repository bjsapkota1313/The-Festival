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
    public function filterArtistPerformancesWithDate($artistPerformances): ?array
    {
        $groupedArtistPerformances = array();
        foreach ($artistPerformances as $artistPerformance) {
            $date = $artistPerformance->getDate()->format('Y-m-d'); // Get the date of the artist performance and grouping with the date ask
            if (!isset($groupedArtistPerformances[$date])) {
                $groupedArtistPerformances[$date] = array(); // check if the date is already in the array, if not create a new array for this date
            }
            $groupedArtistPerformances[$date][] = $artistPerformance; // Adding the artist performance to the array for this date
        }
        return $groupedArtistPerformances;
    }

}