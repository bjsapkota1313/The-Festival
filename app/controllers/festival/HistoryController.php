<?php
require_once __DIR__ . '/EventController.php';
require_once __DIR__ . '/../../services/HistoryService.php';
require_once __DIR__ . '/../../services/EventService.php';

class HistoryController extends EventController
{
    protected $eventService;
    protected HistoryService $historyService;

    public function __construct()
    {
        parent::__construct();
        $this->historyService = new HistoryService();
        $this->eventService = new EventService();
    }

    public function index()
    {
        $eventPage = $this->eventPageService->getEventPageByName('History/Intro');
        $bodyHead = $eventPage->getContent()->getBodyHead();
        $sectionText = $eventPage->getContent()->getSectionText();
        $paragraphs = $sectionText->getParagraphs();
        $allTourLocations = $this->historyService->getAllHistoryTourLocation();
        $this->displayNavBar("A stroll Through History", '/css/festival/history.css');
        $historyEvent = $this->eventService->getEventByName('A Stroll Through History');
        $historyTours = $historyEvent->getHistoryTours();
        $timetable = $this->getarrayAccordingToDate($historyTours);
//        $startingTourLocation = $this->historyService->getHistoryTourLocationsByHistoryTourId(1);

        require __DIR__ . '/../../views/festival/History/index.php';
    }

    public function detail()
    {

        $locationId = $_GET["locationId"];
        $location = $_GET["location"];
        $locationPostCode = $_GET["locationPostCode"];
          $getLocationParagraphsById = $this->historyService->getHistoryTourLocationsByHistoryTourId($location);
        $tourImage = $getLocationParagraphsById->getTourImage();


        $this->displayNavBar("A stroll Through History", '/css/festival/history.css');

        require __DIR__ . '/../../views/festival/History/detail.php';
    }

    public function getAllHistoryTourLocation()
    {
        $allTourLocation = $this->historyService->getAllHistoryTourLocation();
    }

    public function test()
    {
        $historyEvent = $this->eventService->getEventByName('A Stroll Through History');

        print_r($historyEvent);
    }

    private function getarrayAccordingToDate($historyTours)
    {
        // Group the tours by date and time
        $groupedHistoryTours = array();
        foreach ($historyTours as $historyTour) {
            $date = $historyTour->getDate()->format('Y-m-d');
            $time = $historyTour->getDate()->format('H:i');
            if (!isset($groupedHistoryTours[$date])) {
                $groupedHistoryTours[$date] = array();
            }
            if (!isset($groupedHistoryTours[$date][$time])) {
                $groupedHistoryTours[$date][$time] = array();
            }
            $groupedHistoryTours[$date][$time][] = $historyTour;
        }
        return $groupedHistoryTours;
    }
}