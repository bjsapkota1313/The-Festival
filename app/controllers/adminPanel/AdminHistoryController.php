<?php
require_once __DIR__ . '/../../services/HistoryService.php';
require_once __DIR__ . '/AdminPanelController.php';

class AdminHistoryController extends AdminPanelController
{
    private $historyService;
    private $event;

    public function __construct()
    {
        parent::__construct();
        $this->historyService = new HistoryService();
        $this->event = $this->eventService->getEventByName('A Stroll Through History'); //TODO: HardCoded
    }

    public function tourLocations()
    {
        $title = 'Tour Location';
        $this->displaySideBar($title);
        $historyEvent = $this->eventService->getEventByName('A Stroll Through History');
//        $tourLocations = $historyEvent->getHistoryTours()->getHistoryTourLocations();
        $tourLocations = $this->historyService->getAllHistoryTourLocation();
        if (empty($tourLocations)) {
            $errorMessage['tourLocation'] = "No location found in system";
        }
        require_once __DIR__ . '/../../views/AdminPanel/History/HistoryLocationOverview.php';
    }

    public function historyTours()
    {
        $title = 'History Tour';
        $this->displaySideBar($title);

        $historyEvent = $this->eventService->getEventByName('A Stroll Through History');
        $historyTours = $historyEvent->getHistoryTours();

        if (empty($historyTours)) {
            $errorMessage['tourLocation'] = "No location found in system";
        }
        require_once __DIR__ . '/../../views/AdminPanel/History/HistoryTourOverview.php';
    }

    public function addHistoryTourLocation()
    {
        $title = 'Add Tour Location';
        $this->displaySideBar($title);
        if (isset($_POST['addNewTourLocation'])) {
            $this->insertNewTourLocation();
        }
        require_once __DIR__ . '/../../views/AdminPanel/History/AddHistoryLocation.php';
    }

    function insertNewTourLocation()
    {
        // File has been successfully uploaded and moved to the desired folder
        $newTourLocation = array(
            'tourStreetName' => htmlspecialchars($_POST['tourStreetName']),
            'tourCountry' => htmlspecialchars($_POST['tourCountry']),
            'tourStreetNumber' => htmlspecialchars($_POST['tourStreetNumber']),
            'tourPostCode' => htmlspecialchars($_POST['tourPostCode']),
            'tourCity' => htmlspecialchars($_POST['tourCity']),
        );
        $this->historyService->insertNewTourLocation($newTourLocation);
    }

//    public function addHistoryTour()
//    {
//        $title = 'Add History Tour';
//        $this->displaySideBar($title);
////        if (isset($_POST['addNewHistoryTour'])) {
//////            $this->insertNewHistoryTour();
////            $eventDate = DateTime::createFromFormat('Y-m-d', $_POST['newTourDate'])->format('Y-m-d');
////            $eventDateId = $this->historyService->checkEventDateExistence($eventDate);
////            if($eventDateId){
////                echo $eventDateId;
////            }
////            else{
////                echo "fuck bigay";
////            }
////        }
//        if (isset($_POST['addNewHistoryTour'])) {
////            $this->insertNewHistoryTour();
//            $tourLanguage = $_POST['newTourLanguage'];
////            $eventDate = DateTime::createFromFormat('Y-m-d', $_POST['newTourDate'])->format('Y-m-d');
//            $languageId = $this->historyService->checkLanguageExistence($tourLanguage);
//            if($languageId){
//                echo $languageId;
//            }
//            else{
//                echo "fuck bigay";
//            }
//        }
//        require_once __DIR__ . '/../../views/AdminPanel/History/AddHistoryTour.php';
//    }
    public function addHistoryTour()
    {
        $title = 'Add History Tour';
        $this->displaySideBar($title);

        if (isset($_POST['addNewHistoryTour'])) {
            $eventDate = DateTime::createFromFormat('Y-m-d', $_POST['newTourDate'])->format('Y-m-d');
            $language = $_POST['newTourLanguage'];
            $timeTable = $_POST['newTourTime'];

            // Check if event date exists
            $eventDateId = $this->historyService->checkEventDateExistence($eventDate);
            if(!$eventDateId){
                // Event date does not exist, insert new data and get the new ID
                $this->historyService->insertNewEventDate($eventDate);
                $eventDateId = $this->historyService->checkEventDateExistence($eventDate);
            }

            $newTourTimeTableID = $this->historyService->checkTourTimeTableExistence($eventDateId,$timeTable);
            if(!$newTourTimeTableID){
                // Event date does not exist, insert new data and get the new ID
                $this->historyService->insertNewTimeTable($eventDateId,$timeTable);
                $newTourTimeTableID = $this->historyService->checkTourTimeTableExistence($eventDateId,$timeTable);
            }
            echo $newTourTimeTableID;

            // Check if language exists
            $languageId = $this->historyService->checkLanguageExistence($language);
            if(!$languageId){
                // Language does not exist, insert new data and get the new ID
                $this->historyService->insertNewLanguage($language);
                $languageId = $this->historyService->checkLanguageExistence($language);
            }
            // Insert new history tour using the IDs obtained
            $this->historyService->insertNewTourTest($languageId, $newTourTimeTableID);
        }

        require_once __DIR__ . '/../../views/AdminPanel/History/AddHistoryTour.php';
    }

    function insertNewHistoryTour()
    {
        // File has been successfully uploaded and moved to the desired folder
        $newHistoryTour = array(
            'tourStreetName' => htmlspecialchars($_POST['tourStreetName']),
            'tourCountry' => htmlspecialchars($_POST['tourCountry']),
            'tourStreetNumber' => htmlspecialchars($_POST['tourStreetNumber']),
            'tourPostCode' => htmlspecialchars($_POST['tourPostCode']),
            'tourCity' => htmlspecialchars($_POST['tourCity']),
        );
        $this->historyService->insertNewHistoryTour($newHistoryTour);
    }
}
//        $tourLocations = $this->historyService->getAllHistoryTourLocation();

//        $allTourLocations = $this->historyService->getAllHistoryTourLocation();
//        $allLocations = $this->eventService->getAllLocations();
//        $performanceSessions = $this->performanceService->getAllPerformanceSessions();
//        $errorMessage = $this->addPerformanceSubmitted();