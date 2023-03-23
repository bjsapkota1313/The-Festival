<?php
require_once __DIR__ . '/../repositories/ImageRepository.php';
class ImageService
{
    private $imageRepository;
    public function __construct()
    {
        $this->imageRepository = new ImageRepository();
    }

    /**
     * @throws DatabaseQueryException
     */
    public function insertImageAndGetId($imageName){
        return$this->imageRepository->insertImageAndGetId($imageName);
    }

}