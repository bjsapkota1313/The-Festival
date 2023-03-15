<?php
require_once __DIR__ . '/../event.php';
require_once __DIR__ . '/Performance.php';
class DanceEvent extends Event
{
    private array $performances;
    public function __construct()
    {
        $this->performances = array();
    }

    /**
     * @return array
     */
    public function getPerformances(): array
    {
        return $this->performances;
    }

    /**
     * @param array $performances
     */
    public function setPerformances(array $performances): void
    {
        $this->performances = $performances;
    }


}