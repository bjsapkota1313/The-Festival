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
        if (isset($_POST['deleteHistoryTour'])) {
            $selectedTourId = $_POST['deleteTourId'];
            $this->historyService->deleteTest($selectedTourId);

        } elseif (isset($_POST['updateHistoryTour'])) {
            $selectedTourId = $_POST['updateTourId'];
            $this->updateHistoryTourByTourId($selectedTourId);
            // perform update action here
        }

        require_once __DIR__ . '/../../views/AdminPanel/History/HistoryTourOverview.php';
    }
    public function updateHistoryTourByTourId($selectedTourId){
        $title = 'Update History Tour';
        $this->displaySideBar($title);

        $getSelectedTourById = $this->historyService->getHistoryTourById($selectedTourId);
        if(isset($_POST['updateTourLocation'])){
            $updateHistoryTour = array(
                'updateTourLanguage' => htmlspecialchars($_POST['updateTourLanguage']),
                'updateTourDate' => date('Y-m-d', strtotime($_POST['updateTourDate'])),
                'updateTourTime' => date('H:i:s', strtotime($_POST['updateTourTime'])),
            );
            $this->historyService->updateHistoryTourByTourId(37,$updateHistoryTour);
        }

        require_once __DIR__ . '/../../views/AdminPanel/History/UpdateHistoryTour.php';
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
//
//        if (isset($_POST['addNewHistoryTour'])) {
//            $eventDate = DateTime::createFromFormat('Y-m-d', $_POST['newTourDate'])->format('Y-m-d');
//            $language = $_POST['newTourLanguage'];
//            $timeTable = $_POST['newTourTime'];
//            $this->historyService->newTourData($eventDate,$language,$timeTable);
//        }
//
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

            // Check if custom language is selected
            if ($language == 'custom') {
                $customLanguage = $_POST['customLanguage'];
                $language = $customLanguage;
            }

            $this->historyService->newTourData($eventDate, $language, $timeTable);
        }

        require_once __DIR__ . '/../../views/AdminPanel/History/AddHistoryTour.php';
    }



}
