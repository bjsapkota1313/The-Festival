<?php
require_once __DIR__ . '/../repositories/HistoryPageRepository.php';

class HistoryService
{
    private $repository;
    private $repository2;

    public function __construct()
    {
        $this->repository = new HistoryPageRepository();
        $this->repository2 = new HistoryEventRepository();

    }
    public function getGoogleMarkerByLocationName(string $locationName,$locationPostCode){
        return $this->repository->getGoogleMarkerByLocationName($locationName,$locationPostCode);
    }
    public function getAllHistoryTourLocation(){
        return $this->repository->getAllHistoryTourLocation();
    }
    public function getHistoryTourTimeTable(){
        return $this->repository->getHistoryTourTimeTable();
    }
    public function getHistoryTourLocationsByLocationName($locationName){
        return $this->repository2->getHistoryTourLocationsByLocationName($locationName);
    }
    public function getHistoryTourImageByHistoryTourId($historyTourLocationId){
        return $this->repository2->getHistoryTourImageByHistoryTourId($historyTourLocationId);
    }
    public function getHistoryEventByEventId($eventId){
        return $this->repository2->getHistoryEventByEventId($eventId);

    }
    public function getHistoryTourLocationByLocationId($locationId){
        return $this->repository2->getHistoryTourLocationByLocationId($locationId);

    }
}