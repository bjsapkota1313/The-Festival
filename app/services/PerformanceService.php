<?php
require_once __DIR__ . '/../repositories/PerformanceRepository.php';
class PerformanceService
{
    private $artistPerformanceRepository;

    public function __construct()
    {
        $this->artistPerformanceRepository = new PerformanceRepository();
    }
    public function getPerformancesByEventId($eventId): ?array{
        return $this->artistPerformanceRepository->getPerformancesByEventId($eventId);
    }
    public function getAllPerformancesDoneByArtistIdAtEvent($artistId, $eventName): ?array{
        return $this->artistPerformanceRepository->getAllPerformancesDoneByArtistIdAtEvent($artistId, $eventName);
    }
    public function getAllPerformanceSessions(): array|null
    {
        return $this->artistPerformanceRepository->getAllPerformanceSessions();
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
}