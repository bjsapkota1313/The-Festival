<?php
require_once __DIR__ . '/ApiController.php';
require_once __DIR__ . '/../../services/DanceEventService.php';
require_once __DIR__ . '/../../services/ArtistService.php';
require_once __DIR__ . '/../../services/PerformanceService.php';
require_once __DIR__ . '/../../models/Exceptions/uploadFileFailedException.php';
require_once __DIR__ . '/../../models/Exceptions/DatabaseQueryException.php';
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
                echo "Fuck";
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
        //ToDO: add try catch
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])) {
            $responseData = array(
                "success" => false,
                "message" => "Something went wrong while processing your delete request"
            );
            $this->sendHeaders();
            try {
                if($this->artistService->deleteArist(htmlspecialchars($_GET['id']))){
                    $responseData = array(
                        "success" => true,
                        "message" => ""
                    );
                }
            } catch (DatabaseQueryException|uploadFileFailedException $e) {
                $responseData = array(
                    "success" => false,
                    "message" => $e->getMessage());
            }
            echo json_encode($responseData);
        }
    }


    public function venues()
    { //TODO: add delete method
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])) {
            $responseData = array(
                "success" => false,
                "message" => "Something went wrong while processing your delete request for venue"
            );
            $this->sendHeaders();
            try{
                if($this->danceEventService->deleteVenue(htmlspecialchars($_GET['id'])))
                {
                    $responseData = array(
                        "success" => true,
                        "message" => ""
                    );
                }
            }
            catch (DatabaseQueryException $e)
            {
                $responseData = array(
                    "success" => false,
                    "message" => $e->getMessage());
            }
            echo json_encode($responseData);
        }
    }
}