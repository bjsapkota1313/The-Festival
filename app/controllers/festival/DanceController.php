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
        $danceEvent= $this->eventService->getEventByName('Dance');
        $artistPerformances = $danceEvent->getArtistPerformances();
        $timetable = $this->filterArtistPerformancesWithDate($artistPerformances);
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
    private function filterArtistPerformancesWithDate($artistPerformances): ?array
    {

        // Assume that $artistPerformances is the original array
        $groupedArtistPerformances = array();
        foreach ($artistPerformances as $artistPerformance) {
            $date = $artistPerformance->getDate()->format('Y-m-d'); // Get the date of the artist performance
            if (!isset($groupedArtistPerformances[$date])) {
                $groupedArtistPerformances[$date] = array(); // Initialize an empty array for this date
            }
            $groupedArtistPerformances[$date][] = $artistPerformance; // Add the artist performance to the array for this date
        }
        return $groupedArtistPerformances;
    }
    public function test(){
$colors = ['red', 'green', 'blue'];
        $enumClass = $this->create_enum('Color', ...$colors);
        $colorEnum = new $enumClass();

        foreach ($colorEnum->values() as $value) {
            echo $value->name() . "\n";
        }


    }
    function create_enum(string $name, $values): object
    {
        $constants = [];
        foreach ($values as $value) {
            $constantName = strtoupper($value);
            $constants[$constantName] = new class($value, $constantName) {
                private $value;
                private $name;

                public function __construct($value, $name)
                {
                    $this->value = $value;
                    $this->name = $name;
                }

                public function getValue()
                {
                    return $this->value;
                }

                public function name()
                {
                    return $this->name;
                }
            };
        }

        return new class($name, $constants) {
            private $name;
            private $constants;

            public function __construct($name, $constants)
            {
                $this->name = $name;
                $this->constants = $constants;
            }

            public function values()
            {
                return array_values($this->constants);
            }

            public function valueOf($value)
            {
                $constantName = strtoupper($value);
                if (!isset($this->constants[$constantName])) {
                    throw new InvalidArgumentException("Invalid $this->name value: $value");
                }

                return $this->constants[$constantName];
            }
        };
    }
}