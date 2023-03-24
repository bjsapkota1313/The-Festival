<?php
require_once __DIR__ . '/../../Services/availableEventService.php';
require __DIR__ . '/ApiController.php';

class ArtistsController extends ApiController
{
    private $availableEventService;

    public function __construct()
    {
        $this->availableEventService = new AvailableEventService();
    }

    public function retrieveArtistData(){
        try {
            $this->sendHeaders();
            $artist=NULL;

            if (!empty($_GET['id'])) {
                $id = htmlspecialchars($_GET['id']);
                $artist = $this->availableEventService->getParticipatingArtistByIdWithUrl($id);
            }
            echo Json_encode($artist);
        }
        catch (InvalidArgumentException|Exception $e) {
            http_response_code(500); // sending bad request error to APi request if something goes wrong
            echo $e->getMessage();
        }
    }
}


?>
