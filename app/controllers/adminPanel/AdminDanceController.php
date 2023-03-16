<?php
require_once __DIR__ . '/../../services/ArtistService.php';
require_once __DIR__ . '/AdminPanelController.php';
require_once __DIR__ . '/../../services/PerformanceService.php';
require_once __DIR__ . '/../../models/Exceptions/DatabaseQueryException.php';

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
        $title = 'Add Performance';
        $this->displaySideBar($title);
        $allArtists = $this->artistService->getAllArtists();
        $allLocations = $this->eventService->getAllLocations();
        $performanceSessions = $this->performanceService->getAllPerformanceSessions();
        $errorMessage = $this->addPerformanceSubmitted();
        require_once __DIR__ . '/../../views/AdminPanel/Dance/AddArtistPerformance.php';
    }

    private function addPerformanceSubmitted()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['AddArtistPerformance'])) {
            $checkResult = $this->checkFieldsFilledAndSantizeInput($_POST, ['AddArtistPerformance'], ['artists']);
            if (is_string($checkResult)) {
                return $checkResult;
            } else {
                if ($this->checkDateIsInPast('' . $checkResult['performanceDate'] . ' ' . $checkResult['startTime'])) {
                    return "Entered Date and Time is in the Past";
                }
                $checkResult['duration'] = $this->getDurationInMinutes($checkResult['startTime'], $checkResult['endTime']); // adding new key with value to araay
                try {
                    $checkResult = $this->performanceService->addPerformanceWithEventId($this->event->getEventId(), $checkResult);
                    if ($checkResult) {
                        header("location: /admin/dance/performances");
                        exit();
                    } else {
                        return "Error while adding the performance";
                    }
                } catch (DatabaseQueryException $e) {
                    return $e->getMessage(); // will return the error message that got while adding the performance
                }
            }
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

    private function getDurationInMinutes($startTime, $endTime)
    {
        $startTime = new DateTime($startTime);
        $endTime = new DateTime($endTime);
        $duration = $startTime->diff($endTime);
        return $duration->format('%h') * 60 + $duration->format('%i');
    }


}