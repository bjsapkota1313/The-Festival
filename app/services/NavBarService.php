<?php
require_once __DIR__ . '/../repositories/NavBarRepository.php';

class NavBarService
{
    private $navBarRepository;

    public function __construct()
    {
        $this->navBarRepository = new NavBarRepository();
    }

    public function getAllNavBarItems()
    {
        return $this->navBarRepository->getAllNavBarItems();
    }

    public function updateNavBarName($navBarName, $id): bool
    {
        return $this->navBarRepository->updateNavBarName($navBarName, $id);
    }
}