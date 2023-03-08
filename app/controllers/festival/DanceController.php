<?php
require_once __DIR__ . '/EventController.php';
require_once __DIR__ . '/../../services/SpotifyService.php';
require_once __DIR__ . '/../../services/ArtistService.php';
class DanceController extends eventController
{
    private $spotifyService;
    private $artistService;

    public function __construct()
    {
        parent::__construct();
        $this->spotifyService = new SpotifyService();
        $this->artistService = new ArtistService();
    }

    public function index()
    {
        $dancePage = $this->eventPageService->getEventPageByName('Dance/Intro');
        $bodyHead = $dancePage->getContent()->getBodyHead();
        $sectionText = $dancePage->getContent()->getSectionText();
        $paragraphs = $sectionText->getParagraphs();
        $participatingArtists = $this->artistService->getAllArtists();
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
                require __DIR__ . '/../../views/festival/Dance/artist.php';
            } catch (\SpotifyWebAPI\SpotifyWebAPIAuthException $e) {
                echo $e->getMessage();
            }
        }
        else{
            echo "Unauthorised access";
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

}