<?php
require_once __DIR__ . '/../repositories/ArtistRepository.php';
require_once __DIR__ . '/../models/ImageManager.php';

class ArtistService
{
    use ImageManager;
    private $artistRepository;

    public function __construct()
    {
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
     */
    public function addArtist($data, $images)
    {
        $directory = __DIR__ . "/../public/image/Dance";
       // $newImagesNames=$this->getImagesNameByMovingToDirectory($images['others'],$directory);
        unset($images['others']); // removing others array images after updating
        $newImagesNames=$this->getImagesNameByMovingToDirectory($images,$directory);
    }
}

