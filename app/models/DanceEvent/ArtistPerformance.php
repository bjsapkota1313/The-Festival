<?php
require_once __DIR__.'/../Location.php';
class ArtistPerformance
{
    private int $artistPerformanceId;
    private array $artists;
    private DateTime $date;
    private Location $venue;
    private float $duration;
    private string $session;
    public function __construct()
    {
        $this->artists= array();
    }

    /**
     * @return string
     */
    public function getSession(): string
    {
        return $this->session;
    }

    /**
     * @param string $session
     */
    public function setSession(string $session): void
    {
        $this->session = $session;
    }
    /**
     * @return int
     */
    public function getArtistPerformanceId(): int
    {
        return $this->artistPerformanceId;
    }

    /**
     * @param int $artistPerformanceId
     */
    public function setArtistPerformanceId(int $artistPerformanceId): void
    {
        $this->artistPerformanceId = $artistPerformanceId;
    }

    /**
     * @return array
     */
    public function getArtists(): array
    {
        return $this->artists;
    }

    /**
     * @param array $artists
     */
    public function setArtists(array $artists): void
    {
        $this->artists = $artists;
    }

    /**
     * @return DateTime
     */
    public function getDate(): DateTime
    {
        return $this->date;
    }

    /**
     * @param DateTime $date
     */
    public function setDate(DateTime $date): void
    {
        $this->date = $date;
    }
    /**
     * @return Location
     */
    public function getVenue(): Location
    {
        return $this->venue;
    }

    /**
     * @param Location $venue
     */
    public function setVenue(Location $venue): void
    {
        $this->venue = $venue;
    }

    /**
     * @return float
     */
    public function getDuration(): float
    {
        return $this->duration;
    }

    /**
     * @param float $duration
     */
    public function setDuration(float $duration): void
    {
        $this->duration = $duration;
    }

    /**
     * @throws Exception
     */
    public function getEndDateTime(): DateTime // returns EndDateTime of the performance
    {
        $endTime = clone $this->date;
        $endTime->add(new DateInterval('PT' . $this->duration . 'M'));
        return $endTime;
    }

}