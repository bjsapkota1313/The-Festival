<?php
require_once __DIR__ . '/EventController.php';
require_once __DIR__ . '/../../services/SpotifyService.php';
require_once __DIR__ . '/../../services/ArtistService.php';

class DanceController extends eventController
{
    private $spotifyService;
    private $artistService;
    private $danceEventService;

    public function __construct()
    {
        parent::__construct();
        $this->spotifyService = new SpotifyService();
        $this->artistService = new ArtistService();
        $this->danceEventService = new DanceEventService();
    }

    public function index()
    {
        $dancePage = $this->eventPageService->getEventPageByName('Dance/Intro');
        $bodyHead = $dancePage->getContent()->getBodyHead();
        $sectionText = $dancePage->getContent()->getSectionText();
        $paragraphs = $sectionText->getParagraphs();
        $participatingArtists = $this->artistService->getAllArtistsParticipatingInEvent();
        $danceEvent = $this->eventService->getEventByName('Dance'); //TODO: get event by id
        $artistPerformances = $danceEvent->getArtistPerformances();
        $timetable = $this->danceEventService->filterArtistPerformancesWithDate($artistPerformances);
        require __DIR__ . '/../../views/festival/Dance/index.php';
    }


    public function artistDetails()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['artist'])) {
            try {
                $errorMessage = array();
                $artistName = $this->sanitizeInput($_GET['artist']);
                $selectedArtist = $this->artistService->getArtistByName($artistName);
                if (empty($selectedArtist)) {
                    $this->display404PageNotFound();
                }
                try {
                    $artistAlbums = $this->spotifyService->getArtistAlbumsWithLimit($artistName, 6);
                    if (empty($artistAlbums)) {
                        $errorMessage['artistAlbums'] = 'No albums found for this artist';
                    }
                    $artistTopTracks = $this->spotifyService->getArtistTopTracksWithLimit($artistName, 10);
                    if (empty($artistTopTracks)) {
                        $errorMessage['artistTopTracks'] = 'No tracks found for this artist';
                    }
                } catch (\SpotifyWebAPI\SpotifyWebAPIException $e) {
                    $errorMessage['connectionToSpotify'] = $e->getMessage();
                }
                $artistPerformances = $this->danceEventService->getAllArtistPerformancesDoneByArtistIdAtEvent($selectedArtist->getArtistId(), 'Dance');
                $filteredArtistPerformances = $this->danceEventService->filterArtistPerformancesWithDate($artistPerformances);
                require __DIR__ . '/../../views/festival/Dance/artist.php';
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        } else {
            $this->display404PageNotFound();
        }
    }

    private function getFormattedStringToDisplay($string, $length): string
    {
        if (strlen($string) > $length) {
            return substr($string, 0, $length) . "....";
        } else {
            return $string;
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