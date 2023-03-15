<?php
require_once __DIR__ . '/../repositories/AvailableEventRepository.php';
class AvailableEventService
{
    private $availableEventRepository;
    public function __construct()
    {
        $this->availableEventRepository = new AvailableEventRepository();
    }
    public function getAvailableEventsByEventType($type)
    {
        return $this->availableEventRepository->getAvailableEventsByEventType($type);
    }

    public function getAvailableEventsByDate($availableEvents, $date)
    {
        $newList = array();
        foreach ($availableEvents as $count => $availableEvent) {
            if ($availableEvent->getEventDate() == $date) {
                array_push($newList, $availableEvent);
            }
        }
        return $newList;
    }
}