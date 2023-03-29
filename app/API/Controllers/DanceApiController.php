<?php
require_once __DIR__ . '/ApiController.php';
require_once __DIR__ . '/../../services/DanceEventService.php';
require_once __DIR__ . '/../../services/ArtistService.php';
require_once __DIR__ . '/../../services/PerformanceService.php';

class DanceApiController extends ApiController
{
    private $performanceService;
    private $artistService;
    private $danceEventService;

    public function __construct()
    {
        $this->artistService = new ArtistService();
        $this->danceEventService = new DanceEventService();
        $this->performanceService = new PerformanceService();
    }


    public function performances()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])) {
                $this->sendHeaders();
                echo 'fuck';
//                $performanceId = htmlspecialchars($_GET['id']);
//                $this->performanceService->deletePerformanceById($performanceId);
            }

        } catch (InvalidArgumentException|Exception $e) {
            http_response_code(500); // sending bad request error to APi request if something goes wrong
            echo $e->getMessage();
        }
    }

    /**
     * @throws uploadFileFailedException
     */
    public function artists()
    {
        //TDDO: add try catch
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])) {
            $this->sendHeaders();
            $artistId = htmlspecialchars($_GET['id']);
            $this->artistService->deleteArist($artistId);
        }
    }

    public function venues()
    { //TODO: add delete method
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])) {
            $this->sendHeaders();
            $venueId = htmlspecialchars($_GET['id']);
            $this->danceEventService->deleteVenue($venueId);
        }
    }
}