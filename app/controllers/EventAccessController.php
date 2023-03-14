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
        $this->displayNavBar("EventAccess",'/css/festival/eventAccess.css');

        $eventAccesPage = $this->eventPageService->getEventPageByName('EventAccess');
        $bodyHead =  $eventAccesPage->getContent()->getBodyHead();
        $sectionText =  $eventAccesPage->getContent()->getSectionText();
        $paragraphs = $sectionText->getParagraphs();
        $availableEvents = $this->availableEventService->getAvailableEventsByEventType('type');
        $availableEventsList1 = $this->availableEventService->getAvailableEventsByDate($availableEvents, 1);
        $availableEventsList2 = $this->availableEventService->getAvailableEventsByDate($availableEvents, 2);
        $availableEventsList3 = $this->availableEventService->getAvailableEventsByDate($availableEvents, 3);
        $availableEventsList4 = $this->availableEventService->getAvailableEventsByDate($availableEvents, 4);

        require __DIR__ . '/../../views/festival/EventAccess/eventsPage.php';
    }}
?>