<?php
require_once __DIR__ . '/EventController.php';
require_once __DIR__. '/../../services/AvailableEventService.php';

class EventAccessController extends eventController
{
    private $availableEventService;

    public function __construct()
    {
        parent::__construct();
        $this->availableEventService = new AvailableEventService();
    }

    public function index()
    {
        $this->displayNavBar("title",'/css/festival/eventAccess.css');

        $eventAccesPage = $this->eventPageService->getEventPageByName('EventAccess');
        $bodyHead =  $eventAccesPage->getContent()->getBodyHead();
        $sectionText =  $eventAccesPage->getContent()->getSectionText();
        $paragraphs = $sectionText->getParagraphs();
        $availableEvents = $this->availableEventService->getAvailableEventsByEventType('type');
        $availableEventsList1 = $this->availableEventService->getAvailableEventsByDate($availableEvents, 1);
        var_dump($availableEvents);
        //print_r($availableEvents);
        //echo $availableEvents['id'];

        require __DIR__ . '/../../views/festival/EventAccess/eventsPage.php';
    }}
?>