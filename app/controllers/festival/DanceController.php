<?php
require_once __DIR__ . '/EventController.php';

class DanceController extends eventController {
    public function __construct()
    {
        parent::__construct();
    }
    public function index(){
        $dancePage = $this->eventPageService->getEventPageByName('Dance/Intro');
        $bodyHead= $dancePage->getContent()->getBodyHead();
        $sectionText = $dancePage->getContent()->getSectionText();
        $paragraphs = $sectionText->getParagraphs();
        require __DIR__ . '/../../views/festival/Dance/index.php';

    }
    public function artist(){
       require __DIR__ . '/../../views/festival/Dance/artist.html';
    }

}