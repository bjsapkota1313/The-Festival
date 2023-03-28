<?php
require_once __DIR__ . '/../repositories/PerformanceRepository.php';
require_once __DIR__ . '/ArtistService.php';
require_once __DIR__ . '/../models/Exceptions/NotAvailableException.php';
require_once __DIR__ . '/../models/Exceptions/InternalErrorException.php';

class PerformanceService
{
    private $performanceRepository;
    private $artistService;

    public function __construct()
    {
        $this->performanceRepository = new PerformanceRepository();
        $this->artistService = new ArtistService();
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

    /**
     * @throws NotAvailableException
     * @throws DatabaseQueryException
     * @throws InternalErrorException
     */
    public function addPerformanceWithEventId($eventId, $data): bool
    { // check if the artist is available at the time
        $this->checkVenueAvailabilityForPerformance($data['Venue'], $data['performanceDate'], $data['startTime']);
        $this->checkArtistAvailabilityForPerformance($data['artists'], $data['performanceDate'], $data['startTime']);
        return $this->performanceRepository->addPerformanceWithEventId($eventId, $data);
    }

    public function deletePerformanceById($performanceId): bool
    { //TODO:check if the ticket has been sold or not before deleting the performance
        return $this->performanceRepository->deletePerformance($performanceId);
    }

    /**
     * @throws NotAvailableException
     * @throws InternalErrorException
     */
    private function checkArtistAvailabilityForPerformance($performingArtists, $performanceDate, $performanceStartTime): void
    { //checking if artists is array or not
        if (!is_array($performingArtists)) {
            $performingArtists = [$performingArtists]; // if it is not array, making it array
        }
        foreach ($performingArtists as $artist) {
            if (!$this->artistService->isArtistAvailableAtTime($artist, $performanceDate, $performanceStartTime)) {
                $notAvailableArtist = $this->artistService->getArtistByArtistID($artist);
                if (empty($notAvailableArtist)) {
                    throw new InternalErrorException("Something went wrong while checking the artist 
                    availability ,Internally");
                }
                throw new NotAvailableException(" {$notAvailableArtist->getArtistName()} is not available in 
                $performanceDate at $performanceStartTime");
            }
        }
    }

    /**
     * @throws NotAvailableException
     * @throws InternalErrorException
     */
    private function checkVenueAvailabilityForPerformance($locationId, $performanceDate, $performanceStartTime): void
    {
        if (!$this->performanceRepository->isLocationAvailableAtTime($locationId, $performanceDate, $performanceStartTime)) {
            $venue = $this->performanceRepository->getVenueById($locationId);
            if (empty($venue)) {
                throw new InternalErrorException("Something went wrong while checking the venue 
                availability ,Internally");
            }
            throw new NotAvailableException("Location {$venue->getLocationName()} is not available in 
            $performanceDate at $performanceStartTime");
        }

    }
}