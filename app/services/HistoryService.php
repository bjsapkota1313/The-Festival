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
    public function getHistoryTourLocationsByHistoryTourId($historyTourId){
        return $this->repository2->getHistoryTourLocationsByHistoryTourId($historyTourId);
    }
    public function getHistoryTourImageByHistoryTourId($historyTourLocationId){
        return $this->repository2->getHistoryTourImageByHistoryTourId($historyTourLocationId);
    }
}