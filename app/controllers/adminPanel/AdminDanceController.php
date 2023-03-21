<?php
require_once __DIR__ . '/../../services/ArtistService.php';
require_once __DIR__ . '/AdminPanelController.php';
require_once __DIR__ . '/../../services/PerformanceService.php';
require_once __DIR__ . '/../../models/Exceptions/DatabaseQueryException.php';


class AdminDanceController extends AdminPanelController
{
    private $artistService;
    private $danceEventService;
    private $performanceService;

    public function __construct()
    {
        parent::__construct();
        $this->artistService = new ArtistService();
        $this->danceEventService = new DanceEventService();
        $this->performanceService = new PerformanceService();
    }

    public function artists()
    {
        $title = 'Artists';
        $this->displaySideBar($title);
        $artists = $this->artistService->getAllArtists();
        if (empty($artists)) {
            $errorMessage['artists'] = "No Artists found in system";
        }
        require_once __DIR__ . '/../../views/AdminPanel/Dance/artistsOverview.php';
    }

    public function venues()
    {
        $title = 'Venues';
        $this->displaySideBar($title);
        $venues = $this->eventService->getAllLocations();
        if(empty($venues)) {
            $errorMessage['venues'] = "No Venues found in system";
        }
        require_once __DIR__ . '/../../views/AdminPanel/Dance/VenuesOverview.php';
    }
    public function addVenue(){
        $title = 'Add Venue';
        $errorMessage = $this->addVenueSubmitted();
        $this->displaySideBar($title);
        require_once __DIR__ . '/../../views/AdminPanel/Dance/AddVenue.php';
    }
    private function addVenueSubmitted(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['AddVenue'])) {
            $sanitizedInput = $this->checkFieldsFilledAndSantizeInput($_POST, ['AddVenue','houseNumberAdditional']);
            // house number Additional is optional and button is of course
            if (is_string($sanitizedInput)) { // check if the controller sends some error message or not
                return $sanitizedInput;
            } else {
                $dbResult = $this->eventService->addLocation($sanitizedInput); //TODO: check if this is correct
                if ($dbResult) {
                    header("location: /admin/dance/venues");
                    exit();
                } else {
                    return "Error while adding the venue";
                }
            }
        }
    }

    public function addArtist()
    {
        $title = 'Add Artist';
        $this->displaySideBar($title);
        $errorMessage = $this->addArtistSubmitted();
        require_once __DIR__ . '/../../views/AdminPanel/Dance/AddArtist.php';

    }
    private function addArtistSubmitted(){
        if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['AddArtist'])){
            $sanitizedInput = $this->checkFieldsFilledAndSantizeInput($_POST,['AddArtist','artistImage']);
            if(is_string($sanitizedInput)){ // check if the controller sends some error message or not
                return $sanitizedInput;
            }else{
                $dbResult = $this->artistService->addArtist($sanitizedInput);
                if($dbResult){
                    header("location: /admin/dance/artists");
                    exit();
                }else{
                    return "Error while adding the artist";
                }
            }
        }
    }

    public function performances()
    {
        $errorMessage = array();
        $this->displaySideBar('Performances');
        $this->deletePerformance();
        $artistPerformances = $this->getDanceEvent()->getPerformances();
        if (empty($artistPerformances)) {
            $errorMessage['artistPerformances'] = "No Artist Performances found for {$this->getDanceEvent()->getEventName()} event";
        }
        require_once __DIR__ . '/../../views/AdminPanel/Dance/PerformancesOverview.php';
    }
    private function deletePerformance(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
            $id= $this->sanitizeInput($_POST['performanceId']);
            $dbResult = $this->performanceService->deletePerformanceById($id);
        }
    }

    public function addPerformance()
    {
        $title = 'Add Performance';
        $errorMessage = $this->addPerformanceSubmitted();
        $this->displaySideBar($title);
        $allArtists = $this->artistService->getAllArtists();
        $allLocations = $this->eventService->getAllLocations();
        $performanceSessions = $this->performanceService->getAllPerformanceSessions();
        require_once __DIR__ . '/../../views/AdminPanel/Dance/AddPerformance.php';
    }

    private function addPerformanceSubmitted()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['AddArtistPerformance'])) {
            $sanitizedInput = $this->checkFieldsFilledAndSantizeInput($_POST, ['AddArtistPerformance'], ['artists']);
            if (is_string($sanitizedInput)) {
                return $sanitizedInput;
            } else {
                if ($this->checkDateIsInPast('' . $sanitizedInput['performanceDate'] . ' ' . $sanitizedInput['startTime'])) {
                    return "Entered Date and Time is in the Past";
                }
                try {
                    $sanitizedInput['duration'] = $this->getDurationInMinutes($sanitizedInput['startTime'], $sanitizedInput['endTime']); // adding new key with value to array
                    $dbResult = $this->performanceService->addPerformanceWithEventId($this->getDanceEvent()->getEventId(), $sanitizedInput);
                    if ($dbResult) {
                        header("location: /admin/dance/performances");
                        exit();
                    } else {
                        return "Error while adding the performance";
                    }
                } catch (DatabaseQueryException $e) {
                    return $e->getMessage(); // will return the error message that got while adding the performance
                } catch (Exception $e) {
                    return "Something went wrong, Please try again";
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

    private function formatArtistStylesToDisplay($artistStyles)
    {
        $styles = '';
        if (is_array($artistStyles)) {
            foreach ($artistStyles as $artistStyle) {
                $styles = $styles . $artistStyle . ' | ';
            }
            // Remove the last '|' character
            $styles = substr($styles, 0, -2);
        } else {
            $styles = $artistStyles;
        }
        return $styles;
    }

    /**
     * @throws Exception
     */
    private function getDurationInMinutes($startTime, $endTime): float|int|string
    {
        $startTime = new DateTime($startTime);
        $endTime = new DateTime($endTime);
        $duration = $startTime->diff($endTime);
        return $duration->format('%h') * 60 + $duration->format('%i');
    }

}