<?php
require __DIR__ . '/../../Services/ticketService.php';
require __DIR__ . '/ApiController.php';

class TicketsController extends ApiController
{
    private $ticketService;

    public function __construct()
    {
        $this->ticketService = new TicketService();
    }

    public function retrievePreviousTicketId(){
        try {
            $this->sendHeaders();
            $ticketId=NULL;

            $ticketId = $this->ticketService->retrievePreviousTicketId();
            
            echo Json_encode($ticketId);
        }
        catch (InvalidArgumentException|Exception $e) {
            http_response_code(500); // sending bad request error to APi request if something goes wrong
            echo $e->getMessage();
        }
    }



}


?>
