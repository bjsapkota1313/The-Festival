<?php
require_once __DIR__ . '/../event.php';
require_once __DIR__ . '/ArtistPerformance.php';
class DanceEvent extends Event
{
    private array $artistPerformances;
    public function __construct()
    {
        $this->artistPerformances = array();
    }

    /**
     * @return array
     */
    public function getArtistPerformances(): array
    {
        return $this->artistPerformances;
    }

    /**
     * @param array $artistPerformances
     */
    public function setArtistPerformances(array $artistPerformances): void
    {
        $this->artistPerformances = $artistPerformances;
    }

}