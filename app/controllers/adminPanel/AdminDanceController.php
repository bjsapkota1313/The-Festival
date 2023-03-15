<?php
require_once __DIR__ . '/../../services/ArtistService.php';
require_once __DIR__ . '/AdminPanelController.php';
require_once __DIR__ . '/../../services/PerformanceService.php';

class AdminDanceController extends AdminPanelController
{
    private $artistService;
    private $event;
    private $danceEventService;
    private $performanceService;

    public function __construct()
    {
        parent::__construct();
        $this->artistService = new ArtistService();
        $this->event = $this->eventService->getEventByName('Dance'); //TODO: HardCoded
        $this->danceEventService = new DanceEventService();
        $this->performanceService = new PerformanceService();
    }

    public function getAllArtists()
    {
        $this->displaySideBar('Artists');
        $allArtist = $this->artistService->getAllArtists();
        require_once __DIR__ . '/../../views/AdminPanel/Dance/manageArtist.php';
    }

    public function performances()
    {
        $errorMessage = array();
        $this->displaySideBar('Artist Performances');
        $artistPerformances = $this->event->getPerformances();
        if (empty($artistPerformances)) {
            $errorMessage['artistPerformances'] = "No Artist Performances found for {$this->event->getEventName()} event";
        }
        require_once __DIR__ . '/../../views/AdminPanel/Dance/ArtistPerformanceOverview.php';
    }

    public function addPerformance()
    {
        $this->displaySideBar('Add Artist Performance');
        $allArtists = $this->artistService->getAllArtists();
        $allLocations = $this->eventService->getAllLocations();
        $allPerformingSessions = $this->performanceService->getAllPerformanceSessions();
        $this->addPerformanceSubmitted();
        require_once __DIR__ . '/../../views/AdminPanel/Dance/AddArtistPerformance.php';
    }

    private function addPerformanceSubmitted()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['AddArtistPerformance'])) {

            $performanceDate = $this->sanitizeInput($_POST['performanceDate']);
            $performanceStartTime = $this->sanitizeInput($_POST['startTime']);
            $performanceEndTime = $this->sanitizeInput($_POST['endTime']);
            $performanceSessionId = $this->sanitizeInput($_POST['performanceSession']);
            $performanceVenueId = $this->sanitizeInput($_POST['VenueSelect']);
            $performanceTicketsAmount = $this->sanitizeInput($_POST['noOfTicket']);
            $performancePrice = $this->sanitizeInput($_POST['price']);
            $performanceArtists=$this->sanitizeInput($_POST["artists"]);
        }


    }

    private function formatArtistName($artists)
    {
        $name = '';
        if (is_array($artists)) {
            foreach ($artists as $artist) {
                $name = $name . $artist->getArtistName() . ' | ';
            }
            // Remove the last '|' character
            $name = substr($name, 0, -2);
        } else {
            $name = $artists->getArtistName();
        }
        return $name;
    }

}