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

}