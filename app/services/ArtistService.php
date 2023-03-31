<?php
require_once __DIR__ . '/../repositories/ArtistRepository.php';
require_once __DIR__ . '/../models/ImageManager.php';
require_once __DIR__ . '/../services/EventService.php';
require_once __DIR__ . '/../services/ImageService.php';

class ArtistService
{
    use ImageManager;

    private $artistRepository;
    private $imageService;
    private $imageuploadDirectory = __DIR__ . "/../public/image/Festival/Dance/";

    public function __construct()
    {
        $this->imageService = new ImageService();
        $this->artistRepository = new ArtistRepository();
    }

    public function getAllArtists(): ?array
    {
        return $this->artistRepository->getAllArtists();
    }

    public function getArtistByName($name): ?Artist
    {
        return $this->artistRepository->getArtistByName($name);
    }

    public function getArtistByArtistID($artistID): ?Artist
    {
        return $this->artistRepository->getArtistByArtistID($artistID);
    }

    public function getAllArtistsParticipatingInEvent(): ?array
    {
        return $this->artistRepository->getAllArtistsParticipatingInEvent();
    }

    public function getAllParticipatingArtistsInPerformance($artistPerformanceId): ?array
    {
        return $this->artistRepository->getAllParticipatingArtistsInPerformance($artistPerformanceId);
    }

    public function getArtistNameByArtistId($id)
    {
        return $this->artistRepository->getArtistNameByArtistId($id);
    }

    public function getArtistByIdWithUrl($id)
    {
        return $this->artistRepository->getArtistByIdWithUrl($id);
    }

    public function getAllStyles(): ?array
    {
        return $this->artistRepository->getAllStyles();
    }

    /**
     * @throws uploadFileFailedException
     * @throws DatabaseQueryException
     */
    public function addArtist($data, $images): bool
    {
        // checking if the artist already exists in the database or not
        if ($this->artistRepository->artistExistenceInDatabase($data['artistName'], $data['artistDescription'])) {
            throw new DatabaseQueryException("Artist With same name and description already exists");
        }
        $newImagesNamesOthers['others'] = $this->getImagesNameByMovingToDirectory($images['others'], $this->imageuploadDirectory);
        unset($images['others']); // removing others array images after updating
        $newImagesNames = $this->getImagesNameByMovingToDirectory($images, $this->imageuploadDirectory);
        $allImagesNames = array_merge($newImagesNames, $newImagesNamesOthers); // merging  arrays
        $imagesWithId = $this->insertImagesreturnID($allImagesNames);
        return $this->artistRepository->addArtist(array_merge($data, $imagesWithId));
    }

    /**
     * @throws DatabaseQueryException
     */
    public function insertImagesReturnID($images): array
    {
        $imagesID = [];
        foreach ($images as $key => $image) {
            if (is_array($image)) {
                foreach ($image as $key2 => $image2) {
                    $imagesID[$key][$key2] = $this->imageService->insertImageAndGetId($image2);
                }
            } else {
                $insertedID = $this->imageService->insertImageAndGetId($image);
                $imagesID[$key] = $insertedID;
            }
        }
        return $imagesID;
    }

    /**
     * @throws uploadFileFailedException
     * @throws DatabaseQueryException
     */
    public function deleteArist($artistID): bool
    {
        if ($this->artistRepository->isArtistParticipating($artistID)) {
            throw new DatabaseQueryException("Artist is participating in event so cannot be deleted");
        }
        $this->deleteArtistImagesByArtistId($artistID);
        $artistImagesIds = $this->artistRepository->getAllImagesIdOfArtist($artistID);
        if (!empty($artistImagesIds)) {
            $this->deleteArtistImagesFromDb($artistImagesIds); // this will delete images from database
        }
        return $this->artistRepository->deleteArtist($artistID);
    }

    /**
     * @throws uploadFileFailedException
     */
    private function deleteArtistImagesByArtistId($artistId): void
    {
        $artistImages = $this->artistRepository->getAllImagesNameByArtistId($artistId);
        if (!empty($artistImages)) {
            $this->deleteImagesFromDirectory($artistImages, $this->imageuploadDirectory);
        }// if file cannot delete then it will throw exception
    }

    public function isArtistAvailableAtTime($artistId, $date, $time): bool
    {
        return $this->artistRepository->isArtistAvailableAtTime($artistId, $date, $time);
    }

    /**
     * @throws DatabaseQueryException
     */
    public function deleteArtistImagesFromDb($imageIds): void
    {
        foreach ($imageIds as $imageId) {
            if (!$this->imageService->deleteImage($imageId)) {
                throw new DatabaseQueryException("Image could not be deleted");
            };
        }
    }
}

