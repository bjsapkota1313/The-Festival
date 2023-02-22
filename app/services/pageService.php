<?php
require __DIR__ . '/../repositories/pageRepository.php';
require_once __DIR__ . '/../models/page.php';

class PageService
{
    
    public function getPageById(int $pageId)
    {
        $repository = new PageRepository();
        return $repository->getPageById($pageId);
    }
    public function getPageByTitle(string $pageTitle)
    {
        $repository = new PageRepository();
        return $repository->getPageByTitle($pageTitle);
    }


    public function createNewPage($newPage): void
    {
        $repository = new PageRepository();
        $repository->createNewPage($newPage);
    }
}
