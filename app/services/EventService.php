<?php
require_once __DIR__ . '/../repositories/EventRepository.php';
class EventService
{
    private $eventRepository;
    private $eventPageRepository;
    public function __construct()
    {
        $this->eventRepository = new EventRepository();
        $this->eventPageRepository = new EventPageRepository();
    }
    public function getEventByName($name)
    {
        return $this->eventRepository->getEventByName($name);
    }
    public function getAllLocations(){
        return $this->eventRepository->getAllLocations();
    }
    public function getParagraphByEventId($eventId){
        return $this->eventPageRepository->getParagraphByEventId($eventId);
    }
}