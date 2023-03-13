<?php
class HistoryTour
{
    private int $historyTourId;
    private string $tourLanguage;
    private array $historyTourLocations;
    private DateTime $date;
    private float $duration;

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
     * @return int
     */
    public function getHistoryTourId(): int
    {
        return $this->historyTourId;
    }

    /**
     * @param int $historyTourId
     */
    public function setHistoryTourId(int $historyTourId): void
    {
        $this->historyTourId = $historyTourId;
    }


    public function __construct()
    {
        $this->historyTourLocations= array();
    }


    /**
     * @return string
     */
    public function getTourLanguage(): string
    {
        return $this->tourLanguage;
    }

    /**
     * @param string $tourLanguage
     */
    public function setTourLanguage(string $tourLanguage): void
    {
        $this->tourLanguage = $tourLanguage;
    }

    /**
     * @return array
     */
    public function getHistoryTourLocations(): array
    {
        return $this->historyTourLocations;
    }

    /**
     * @param array $historyTourLocations
     */
    public function setHistoryTourLocations(array $historyTourLocations): void
    {
        $this->historyTourLocations = $historyTourLocations;
    }




}