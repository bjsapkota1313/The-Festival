<?php
require_once __DIR__ . '/ApiController.php';
require_once __DIR__ . '/../../models/ImageManager.php';

class InfoPagesImagesController extends ApiController
{
    use ImageManager;

    function uploadImage()
    {
        $infoImagesDir = __DIR__ . '/../../public/image/InfoPages/';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $uploadingImage = $_FILES['image'];
            $baseurl = "http://" . $_SERVER['HTTP_HOST'] . "/image/InfoPages/";
            try {
                $this->checkValidImageOrNot($uploadingImage);
                $imageName = $this->getUniqueImageNameByImageName($uploadingImage);
                $this->moveImageToSpecifiedDirectory($uploadingImage, $infoImagesDir . $imageName);
            } catch (uploadFileFailedException $e) {
                $this->respondWithError(500, $e->getMessage());
                return;
            }
            $this->respond(array('location' => $baseurl . $imageName));
        }
    }


}