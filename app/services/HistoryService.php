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
    public function getHistoryEventByEventId($eventId){
        return $this->repository2->getHistoryEventByEventId($eventId);

    }
    public function getHistoryTourLocationByLocationId($locationId){
        return $this->repository2->getHistoryTourLocationByLocationId($locationId);

    }
    public function insertNewTourLocation($newTourLocation){
        return $this->repository2->insertNewTourLocation($newTourLocation);
    }
    public function insertNewHistoryTour($newHistoryTour){
        return $this->repository2->insertNewHistoryTour($newHistoryTour);
    }
    public function checkEventDateExistence($eventDate){
        return $this->repository2->checkEventDateExistence($eventDate);
    }
    public function checkLanguageExistence($newTourLanguage){
        return $this->repository2->checkLanguageExistence($newTourLanguage);

    }
    public function insertNewEventDate($eventDate)
    {
        return $this->repository2->insertNewEventDate($eventDate);
    }
    public function insertNewLanguage($language){
        return $this->repository2->insertNewLanguage($language);
    }
    public function getEventDateId($eventDate)
    {
        return $this->repository2->getEventDateId($eventDate);
    }
    public function checkTourTimeTableExistence($eventDateId,$timeTable){
        return $this->repository2->checkTourTimeTableExistence($eventDateId,$timeTable);

    }
    public function insertNewTimeTable($eventDateId,$time){
        return $this->repository2->insertNewTimeTable($eventDateId,$time);
    }
    public function insertNewTourTest($languageId,$timeTableId){
        return $this->repository2->insertNewTourTest($languageId,$timeTableId);
    }
}