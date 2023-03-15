<?php
require_once __DIR__ . '/../../services/ArtistService.php';
require_once __DIR__.'/AdminPanelController.php';

class DanceController extends AdminPanelController
{
    private $artistService;
    private $event;
    private $danceEventService;

    public function __construct()
    {
        parent::__construct();
        $this->artistService = new ArtistService();
        $this->event = $this->eventService->getEventByName('Dance'); //TODO: HardCoded
        $this->danceEventService = new DanceEventService();
    }

    public function getAllArtists(){
        $this->displaySideBar('Artists');
        $allArtist = $this->artistService->getAllArtists();
        require_once __DIR__ . '/../../views/AdminPanel/Dance/manageArtist.php';
    }
    public function artistPerformances(){
        $errorMessage=array();
        $this->displaySideBar('Artist Performances');
        $artistPerformances=$this->event->getArtistPerformances();
        if(empty($artistPerformances)){
            $errorMessage['artistPerformances'] = "No Artist Performances found for {$this->event->getEventName()} event";
        }
        require_once __DIR__ . '/../../views/AdminPanel/Dance/ArtistPerformanceOverview.php';
    }
    public function addArtistPerformance(){
        $this->displaySideBar('Add Artist Performance');
        $allArtists = $this->artistService->getAllArtists();
        $allPerformingSessions = $this->danceEventService->getAllArtistPerformanceSessions();
        require_once __DIR__ . '/../../views/AdminPanel/Dance/AddArtistPerformance.php';
    }
    private function formatArtistName($artists){
        $name='';
        if(is_array($artists)){
            foreach ($artists as $artist ){
                $name=$name.$artist->getArtistName().' | ';
            }
            // Remove the last '|' character
            $name = substr($name, 0, -2);
        }
        else{
            $name=$artists->getArtistName();
        }
        return $name;
    }

}