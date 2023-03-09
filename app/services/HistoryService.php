<?php
require_once __DIR__ . '/../repositories/HistoryPageRepository.php';

class HistoryService
{
    private $repository;

    public function __construct()
    {
        $this->repository = new HistoryPageRepository();
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
}