<?php
require_once __DIR__ . '/../repositories/OrderTicketRepository.php';
class OrderTicketService
{
    private $orderTicketRepository;
    public function __construct()
    {
        $this->orderTicketRepository = new OrderTicketRepository();
    }
    public function getTicketById($id)
    {
        return $this->orderTicketRepository->getTicketById($id);
    }

    public function addTicket($ticketId, $availableEventId, $ticketOptions, $orderId)
    {
        return $this->orderTicketRepository->addTicket($ticketId, $availableEventId, $ticketOptions, $orderId);
    }

    public function retrievePreviousTicket()
    {
        return $this->orderTicketRepository->retrievePreviousTicket();
    }

    public function retrievePreviousTicketId()
    {
        return $this->orderTicketRepository->retrievePreviousTicketId();
    }

}