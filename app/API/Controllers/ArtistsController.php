<?php
require __DIR__ . '/../../Services/artistService.php';
require __DIR__ . '/ApiController.php';

class ArtistsController extends ApiController
{
    private $artistService;

    public function __construct()
    {
        $this->artistService = new ArtistService();
    }

    public function retrieveArtistData(){
        try {
            $this->sendHeaders();
            $artist=NULL;

            if (!empty($_GET['id'])) {
                $id = htmlspecialchars($_GET['id']);
                $artist = $this->artistService->getArtistByIdWithUrl($id);
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
