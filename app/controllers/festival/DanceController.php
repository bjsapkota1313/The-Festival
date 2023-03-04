<?php
require_once __DIR__ . '/EventController.php';
require_once __DIR__.'/../../services/SpotifyService.php';


class DanceController extends eventController
{
    private $SpotifyService;

    public function __construct()
    {
        parent::__construct();
        $this->SpotifyService = new SpotifyService();
    }

    public function index()
    {
        $dancePage = $this->eventPageService->getEventPageByName('Dance/Intro');
        $bodyHead = $dancePage->getContent()->getBodyHead();
        $sectionText = $dancePage->getContent()->getSectionText();
        $paragraphs = $sectionText->getParagraphs();
        require __DIR__ . '/../../views/festival/Dance/index.php';

    }

    public function artist()
    {
        try {
            $artistAlbums = $this->SpotifyService->getArtistAlbumsWithLimit('Prakash saput', 6);
            $artistTopTracks = $this->SpotifyService->getArtistTopTracksWithLimit('Prakash saput', 10);
            require __DIR__ . '/../../views/festival/Dance/artist.php';
        } catch (\SpotifyWebAPI\SpotifyWebAPIAuthException $e) {
            echo $e->getMessage();
        }

    }



    public function test()
    {
       $ip= $_SERVER['REMOTE_ADDR'];
       $countrycode = geoip_country_code_by_name($ip);
        echo $countrycode;
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