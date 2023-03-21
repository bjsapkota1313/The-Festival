<?php
require_once __DIR__ . '/../repositories/PerformanceRepository.php';

class PerformanceService
{
    private $performanceRepository;

    public function __construct()
    {
        $this->performanceRepository = new PerformanceRepository();
    }

    public function getPerformancesByEventId($eventId): ?array
    {
        return $this->performanceRepository->getPerformancesByEventId($eventId);
    }

    public function getAllPerformancesDoneByArtistIdAtEvent($artistId, $eventName): ?array
    {
        return $this->performanceRepository->getAllPerformancesDoneByArtistIdAtEvent($artistId, $eventName);
    }

    public function getAllPerformanceSessions(): ?array
    {
        return $this->performanceRepository->getAllPerformanceSessions();
    }

    public function groupPerformancesWithDate($performances): ?array
    {
        $groupedPerformances = array();
        foreach ($performances as $performance) {
            $date = $performance->getDate()->format('Y-m-d'); // Get the date of the artist performance and grouping with the date ask
            if (!isset($groupedPerformances[$date])) {
                $groupedPerformances[$date] = array(); // check if the date is already in the array, if not create a new array for this date
            }
            $groupedPerformances[$date][] = $performance; // Adding the artist performance to the array for this date
        }
        return $groupedPerformances;
    }

    public function addPerformanceWithEventId($eventId, $data): bool
    {
        return $this->performanceRepository->addPerformanceWithEventId($eventId, $data);
    }
    public function deletePerformanceById($performanceId): bool
    {
        return $this->performanceRepository->deletePerformance($performanceId);
    }

}