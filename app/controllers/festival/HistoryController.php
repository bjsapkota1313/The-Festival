<?php
require_once __DIR__ . '/EventController.php';
require_once __DIR__ . '/../../services/HistoryService.php';

class HistoryController extends EventController
{

    protected HistoryService $historyService;

    public function __construct()
    {
        parent::__construct();
        $this->historyService = new HistoryService();
    }

    public function index(){
        $eventPage=$this->eventPageService->getEventPageByName('History/Intro');
        $bodyHead= $eventPage->getContent()->getBodyHead();
        $sectionText = $eventPage->getContent()->getSectionText();
        $paragraphs = $sectionText->getParagraphs();
        $allTourLocations = $this->historyService->getAllHistoryTourLocation();
        $this->displayNavBar("A stroll Through History",'/css/festival/history.css');
        require __DIR__ . '/../../views/festival/History/index.php';
    }
    public function detail(){

        $location = $_GET["location"];
        $locationPostCode = $_GET["locationPostCode"];

        $this->displayNavBar("A stroll Through History",'/css/festival/history.css');

//        require __DIR__ . '/../../views/festival/History/detail?locationName=' .$locationName;

        require __DIR__ . '/../../views/festival/History/detail.php';
    }
    public function getGoogleMarkerByLocationName(){
        $locationName = $_GET["location"];
        $locationPostCode = $_GET["locationPostCode"];
        return $this->historyService->getGoogleMarkerByLocationName($locationName,$locationPostCode);
    }
    public function getAllHistoryTourLocation() {
        $allTourLocation = $this->historyService->getAllHistoryTourLocation();
    }
}