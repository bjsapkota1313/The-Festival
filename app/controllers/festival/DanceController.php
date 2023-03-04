<?php
require_once __DIR__ . '/EventController.php';
require_once __DIR__ . '/../../Vendor/autoload.php';

class DanceController extends eventController
{
    private $SpotifyAccessToken;

    public function __construct()
    {
        parent::__construct();
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
        try{
            $artistAlbums = $this->getArtistAlbums('BTS', 6);
            $artistTopTracks = $this->getArtistTopTracksWithLimit('BTS', 10,'NL');
            require __DIR__ . '/../../views/festival/Dance/artist.php';
        }
        catch (\SpotifyWebAPI\SpotifyWebAPIAuthException $e){
            echo $e->getMessage();
        }

    }

    private function createSpotifySession()
    {
        try {
            require __DIR__ . '/../../config/RESTAPIsConfig/SpotifyConfig.php';
            $session = new SpotifyWebAPI\Session(
                $clientId,
                $clientSecret
            );
            $session->requestCredentialsToken();
            $this->SpotifyAccessToken = $session->getAccessToken();
            $api = new SpotifyWebAPI\SpotifyWebAPI();
            $api->setAccessToken($this->SpotifyAccessToken);
            return $api;
        } catch ( \SpotifyWebAPI\SpotifyWebAPIException | \SpotifyWebAPI\SpotifyWebAPIAuthException  $e) {
            echo $e->getMessage();
        }

    }

    public function test()
    {
        try {
            $api = $this->createSpotifySession();
            if (!empty($api)) {
                $artistName = 'Martin Garrix';
                // Search for the artist
                $results = $api->search($artistName, 'artist');
                // Get the first artist from the results
                $artist = $results->artists->items[0];
                // Get the artist's albums
                $albums = $api->getArtistAlbums($artist->id, [
                    'limit' => 5
                ]);
                // Do something with the track details...
                // Loop through the albums and print their names
                foreach ($albums->items as $album) {
//                    echo substr($album->name,0,7) ."....". "<br>";
                    echo $this->getFormattedStringToDisplay($album->name, 10) . "<br>";
                }
            } else {
                echo "No access token";
            }
        } catch (\SpotifyWebAPI\SpotifyWebAPIException | \SpotifyWebAPI\SpotifyWebAPIAuthException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @throws \SpotifyWebAPI\SpotifyWebAPIAuthException
     */
    private function getArtistAlbums($artistName, $limit): object|array
    {
        $api = $this->createSpotifySession();
        if (!empty($api)) {
            // Search for the artist
            $results = $api->search($artistName, 'artist');
            // Get the first artist from the results
            $artist = $results->artists->items[0];
            // Get the artist's albums
            $albums = $api->getArtistAlbums($artist->id, [
                'limit' => $limit
            ]);
            return $albums;
        } else {
            throw  new \SpotifyWebAPI\SpotifyWebAPIAuthException("Unable to connect with spotify");
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

    /**
     * @throws \SpotifyWebAPI\SpotifyWebAPIAuthException
     */
    private function getArtistTopTracksWithLimit($artistName, $limit, $marketCountry): object|array
    {
        $api = $this->createSpotifySession();
        if (!empty($api)) {
            // Search for the artist
            $results = $api->search($artistName, 'artist');
            // Get the first artist from the results
            $artist = $results->artists->items[0];
            // Get the artist's top tracks in the selecected country
            $topTracks = $api->getArtistTopTracks($artist->id, [
                'market' => $marketCountry
            ]);

            // returning desired track limit
            return  array_slice($topTracks->tracks, 0, $limit);

        } else {
            throw  new \SpotifyWebAPI\SpotifyWebAPIAuthException("Unable to connect with spotify");
        }
    }

}