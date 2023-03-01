<?php
require_once __DIR__ . '/EventController.php';
require_once __DIR__ . '/../../services/EventPageService.php';
class DanceController extends eventController {
private $eventPageService;
    public function __construct()
    {
        parent::__construct();
        $this->eventPageService = new EventPageService();
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