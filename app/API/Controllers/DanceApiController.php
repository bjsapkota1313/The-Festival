<?php
require_once __DIR__ . '/ApiController.php';
require_once __DIR__ . '/../../services/DanceEventService.php';
require_once __DIR__ . '/../../services/ArtistService.php';
require_once __DIR__ . '/../../services/PerformanceService.php';
require_once __DIR__ . '/../../models/Exceptions/uploadFileFailedException.php';
require_once __DIR__ . '/../../models/Exceptions/DatabaseQueryException.php';
require_once __DIR__ . '/../../models/Location.php';

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

    public function artists()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])) {
            $responseData = array(
                "success" => false,
                "message" => "Something went wrong while processing your delete request"
            );
            $this->sendHeaders();
            try {
                if ($this->artistService->deleteArist(htmlspecialchars($_GET['id']))) {
                    $responseData = array(
                        "success" => true,
                        "message" => ""
                    );
                }
            } catch (DatabaseQueryException| uploadFileFailedException $e) {
                $responseData = array(
                    "success" => false,
                    "message" => $e->getMessage());
            }
            echo json_encode($responseData);
        }
        else if ($_SERVER['REQUEST_METHOD'] === 'PUT' && isset($_GET['artistId'])) {
            $this->sendHeaders();
            $data=array();
            echo json_encode($this->editArtist($data));
        }
    }


    public function venues()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['venueId'])) {
            $responseData = array(
                "success" => false,
                "message" => "Something went wrong while processing your delete request for venue"
            );
            $this->sendHeaders();
            try {
                if ($this->danceEventService->deleteVenue(htmlspecialchars($_GET['venueId']))) {
                    $responseData = array(
                        "success" => true,
                        "message" => ""
                    );
                }
            } catch (DatabaseQueryException $e) {
                $responseData = array(
                    "success" => false,
                    "message" => $e->getMessage());
            }
            echo json_encode($responseData);
        }
        else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            $this->sendHeaders();
            $data = json_decode(file_get_contents('php://input'), true);
            if (empty($data)) {
                http_response_code(400);
                return;
            }
            $address = $this->createObjectFromPostedJsonWithSetters(Address::class, $data['address']);
            $venue = $this->createVenueInstance(htmlspecialchars($data['venueId']), htmlspecialchars($data['venueName']), $address);
            $this->sendHeaders();
            echo json_encode($this->editVenue($venue));
        }
    }

    private function editVenue($venue): array
    {
        $responseData = array(
            "success" => false,
            "message" => "Something went wrong while processing your Edit request for venue"
        );
        try {
            if ($this->danceEventService->updateVenue($venue)) {
                $responseData = array(
                    "success" => true,
                    "message" => ""
                );
            }
        } catch (DatabaseQueryException $e) {
            $responseData = array(
                "success" => false,
                "message" => $e->getMessage());
        }
        return $responseData;
    }
    private function editArtist($artist): array
    {
        $responseData = array(
            "success" => false,
            "message" => "Something went wrong while processing your Edit request for artist"
        );
        try {
//            if ($this->artistService->updateArtist($artist)) {
                $responseData = array(
                    "success" => true,
                    "message" => ""
                );
//            }
        } catch (DatabaseQueryException | uploadFileFailedException $e) {
            $responseData = array(
                "success" => false,
                "message" => $e->getMessage());
        }
        return $responseData;
    }

    private function createVenueInstance($id, $name, $address): Location
    {
        $location = new Location();
        $location->setLocationId($id);
        $location->setLocationName($name);
        $location->setAddress($address);
        return $location;
    }

}