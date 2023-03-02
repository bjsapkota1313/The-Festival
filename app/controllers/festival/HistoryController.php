<?php
require_once __DIR__ . '/EventController.php';
class HistoryController extends EventController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        $eventPage=$this->eventPageService->getEventPageByName('History/Intro');
        $bodyHead= $eventPage->getContent()->getBodyHead();
        $sectionText = $eventPage->getContent()->getSectionText();
        $paragraphs = $sectionText->getParagraphs();
        $this->displayNavBar("A stroll Through History",'/css/festival/history.css');
        require __DIR__ . '/../../views/festival/History/index.php';
    }
    public function detail(){
        $this->displayNavBar("A stroll Through History",'/css/festival/history.css');
        require __DIR__ . '/../../views/festival/History/detail.php';
    }
}