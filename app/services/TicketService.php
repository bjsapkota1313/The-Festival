<?php
require_once __DIR__ . '/../repositories/TicketRepository.php';
class TicketService
{
    private $ticketRepository;
    public function __construct()
    {
        $this->ticketRepository = new TicketRepository();
    }
    public function getTicketById($id)
    {
        return $this->ticketRepository->getTicketById($id);
    }

    public function addTicket($ticketId, $availableEventId, $ticketOptions, $orderId)
    {
        return $this->ticketRepository->addTicket($ticketId, $availableEventId, $ticketOptions, $orderId);
    }

    public function retrievePreviousTicket()
    {
        return $this->ticketRepository->retrievePreviousTicket();
    }

    public function retrievePreviousTicketId()
    {
        return $this->ticketRepository->retrievePreviousTicketId();
    }

}