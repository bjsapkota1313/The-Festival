<?php
require_once __DIR__ . '/../repositories/ArtistRepository.php';
class ArtistService
{
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
    public function getAllParticipatingArtistsInPerformance($artistPerformanceId): ?array{
        return $this->artistRepository->getAllParticipatingArtistsInPerformance($artistPerformanceId);
    }
    
    public function getArtistNameByArtistId($id)
    {
        return $this->artistRepository->getArtistNameByArtistId($id);
    }
}
