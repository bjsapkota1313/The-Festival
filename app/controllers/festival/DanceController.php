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
        $participatingArtists = $this->artistService->getAllArtists();
        $danceEvent= $this->eventService->getEventByName('Dance'); //TODO: get event by id
        $artistPerformances = $danceEvent->getArtistPerformances();
        $timetable = $this->danceEventService->filterArtistPerformancesWithDate($artistPerformances);
        require __DIR__ . '/../../views/festival/Dance/index.php';
    }


    public function artistDetails()
    {
        if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['artist'])){
            try {
                $artistName = htmlspecialchars($_GET['artist']);
                $selectedArtist = $this->artistService->getArtistByName($artistName);
                $artistAlbums = $this->spotifyService->getArtistAlbumsWithLimit($artistName, 6);
                $artistTopTracks = $this->spotifyService ->getArtistTopTracksWithLimit($artistName, 10);
                $artistImages = $this->getFilterdImagesByImageSpecification($selectedArtist->getArtistImages());
                $artistPerformances = $this->danceEventService->getAllArtistPerformancesDoneByArtistIdAtEvent($selectedArtist->getArtistId(),'Dance');
                $filteredArtistPerformances = $this->danceEventService->filterArtistPerformancesWithDate($artistPerformances);
                require __DIR__ . '/../../views/festival/Dance/artist.php';
            } catch (\SpotifyWebAPI\SpotifyWebAPIAuthException $e) {
                echo $e->getMessage();
            }
        }
        else{
            echo "Unauthorised access";
        }
    }
    private function getFilterdImagesByImageSpecification($artistImages): ?array
    {
        if($artistImages==null){
            return null;
        }
        $newArray = array();
        foreach ($artistImages as $image) {
            foreach ($image as $key => $value) {
                if (isset($newArray[$key])) {
                    $newArray[$key][] = $value;
                } else {
                    $newArray[$key] = array($value);
                }
            }
        }
        return $newArray;
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
        try{
            $date = new DateTime($dateString); // Create a DateTime object from the date string
            return $date->format('l');
        }
        catch (Exception $e){
            return "Unknown";
        }
    }
}