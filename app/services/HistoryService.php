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

    public function getGoogleMarkerByLocationName(string $locationName, $locationPostCode)
    {
        return $this->repository->getGoogleMarkerByLocationName($locationName, $locationPostCode);
    }

    public function getAllHistoryTourLocation()
    {
        return $this->repository->getAllHistoryTourLocation();
    }

    public function getHistoryTourTimeTable()
    {
        return $this->repository->getHistoryTourTimeTable();
    }

    public function getHistoryTourLocationsByHistoryTourId($historyTourId)
    {
        return $this->repository2->getHistoryTourLocationsByHistoryTourId($historyTourId);
    }

    public function getHistoryTourImageByHistoryTourId($historyTourLocationId)
    {
        return $this->repository2->getHistoryTourImageByHistoryTourId($historyTourLocationId);
    }

    public function getHistoryEventByEventId($eventId)
    {
        return $this->repository2->getHistoryEventByEventId($eventId);

    }

    public function getHistoryTourLocationByLocationId($locationId)
    {
        return $this->repository2->getHistoryTourLocationByLocationId($locationId);

    }

    public function insertNewTourLocation($newTourLocation)
    {
        return $this->repository2->insertNewTourLocation($newTourLocation);
    }

    public function insertNewHistoryTour($newHistoryTour)
    {
        return $this->repository2->insertNewHistoryTour($newHistoryTour);
    }

    public function checkEventDateExistence($eventDate)
    {
        $eventDateId = $this->repository2->checkEventDateExistence($eventDate);
        if (!$eventDateId) {
            // Event date does not exist, insert new data and get the new ID
            $this->repository2->insertNewEventDate($eventDate);
            $eventDateId = $this->repository2->checkEventDateExistence($eventDate);
        }
        return $eventDateId;
    }
//    public function checkLanguageExistence($newTourLanguage){
//        return $this->repository2->checkLanguageExistence($newTourLanguage);
//    }
//    public function insertNewEventDate($eventDate)
//    {
//        return $this->repository2->insertNewEventDate($eventDate);
//    }
//    public function insertNewLanguage($language){
//        return $this->repository2->insertNewLanguage($language);
//    }
    public function getEventDateId($eventDate)
    {
        return $this->repository2->getEventDateId($eventDate);
    }

    public function checkTourTimeTableExistence($eventDateId, $timeTable)
    {

        $newTourTimeTableID = $this->repository2->checkTourTimeTableExistence($eventDateId, $timeTable);
        if (!$newTourTimeTableID) {
            // Event date does not exist, insert new data and get the new ID
            $this->repository2->insertNewTimeTable($eventDateId, $timeTable);
            $newTourTimeTableID = $this->repository2->checkTourTimeTableExistence($eventDateId, $timeTable);
        }
        return $newTourTimeTableID;
    }
//    public function insertNewTimeTable($eventDateId,$time){
//        return $this->repository2->insertNewTimeTable($eventDateId,$time);
//    }
//    public function insertNewTourTest($languageId,$timeTableId){
//        return $this->repository2->insertNewTourTest($languageId,$timeTableId);
//    }

    public function newTourData($eventDate, $language, $timeTable)
    {
        $eventDateId = $this->checkEventDateExistence($eventDate);
        $timeTableId = $this->checkTourTimeTableExistence($eventDateId, $timeTable);
        $languageId = $this->checkLanguageExistence($language);

        return $this->repository2->insertNewTourTest($languageId, $timeTableId);
    }

    public function getHistoryTourById($selectedTourId)
    {
        return $this->repository2->getHistoryTourById($selectedTourId);
    }

    public function checkLanguageExistence($newTourLanguage)
    {
        $languageId = $this->repository2->checkLanguageExistence($newTourLanguage);
        if (!$languageId) {
            // Language does not exist, insert new data and get the new ID
            $this->repository2->insertNewLanguage($newTourLanguage);
            $languageId = $this->repository2->checkLanguageExistence($newTourLanguage);
        }
        return $languageId;
    }

    public function deleteTest($selectedTourId)
    {
        $this->repository2->deleteTest($selectedTourId);
    }

    public function updateHistoryTourByTourId($selectedTourId, $updateHistoryTour)
    {
        $this->repository2->updateHistoryTourByTourId($selectedTourId,$updateHistoryTour);
    }
}