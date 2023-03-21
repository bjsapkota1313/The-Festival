<?php
require_once __DIR__ . '/EventController.php';
require_once __DIR__ . '/../../services/SpotifyService.php';
require_once __DIR__ . '/../../services/ArtistService.php';

class DanceController extends eventController
{
    private $spotifyService;
    private $artistService;
    private $danceEventService;
    private $performanceService;

    public function __construct()
    {
        parent::__construct();
        $this->spotifyService = new SpotifyService();
        $this->artistService = new ArtistService();
        $this->danceEventService = new DanceEventService();
        $this->performanceService = new PerformanceService();
    }

    public function index()
    {
        $dancePage = $this->eventPageService->getEventPageByName('Dance/Intro');
        $bodyHead = $dancePage->getContent()->getBodyHead();
        $sectionText = $dancePage->getContent()->getSectionText();
        $paragraphs = $sectionText->getParagraphs();
        $participatingArtists = $this->artistService->getAllArtistsParticipatingInEvent();
        $danceEvent = $this->eventService->getEventByName('Dance'); //TODO: get event by id
        $artistPerformances = $danceEvent->getPerformances();
        $groupedPerformances = $this->performanceService->groupPerformancesWithDate($artistPerformances);
        require __DIR__ . '/../../views/festival/Dance/index.php';
    }
    public function artistDetails()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['artist'])) {
            try {
                $errorMessage = array();
                $artistId = $this->sanitizeInput($_GET['artist']);
                $selectedArtist = $this->artistService->getArtistByArtistID($artistId);
                if (empty($selectedArtist)) {
                    $this->display404PageNotFound();
                }
                try {
                    $artistAlbums = $this->spotifyService->getArtistAlbumsWithLimit($artistId, 6);
                    if (empty($artistAlbums)) {
                        $errorMessage['artistAlbums'] = 'No albums found for this artist';
                    }
                    $artistTopTracks = $this->spotifyService->getArtistTopTracksWithLimit($artistId, 10);
                    if (empty($artistTopTracks)) {
                        $errorMessage['artistTopTracks'] = 'No tracks found for this artist';
                    }
                } catch (\SpotifyWebAPI\SpotifyWebAPIException $e) {
                    $errorMessage['connectionToSpotify'] = $e->getMessage();
                }
                $artistPerformances = $this->performanceService->getAllPerformancesDoneByArtistIdAtEvent($selectedArtist->getArtistId(), 'Dance');
                $filteredArtistPerformances = $this->performanceService->groupPerformancesWithDate($artistPerformances);
                require __DIR__ . '/../../views/festival/Dance/artist.php';
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        } else {
            $this->display404PageNotFound();
        }
    }

    private function getDayByDateString($dateString): string
    {
        try {
            $date = new DateTime($dateString); // Create a DateTime object from the date string
            return $date->format('l');
        } catch (Exception $e) {
            return "Unknown";
        }
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