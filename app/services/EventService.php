<?php
require_once __DIR__ . '/../repositories/EventRepository.php';
class EventService
{
    private $eventRepository;
    public function __construct()
    {
        $this->eventRepository = new EventRepository();
    }
    public function getEventByName($name)
    {
        return $this->eventRepository->getEventByName($name);
    }
    public function getAllLocations()
    {
        return $this->eventRepository->getAllLocations();
    }
}