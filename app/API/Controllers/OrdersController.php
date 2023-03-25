<?php
require __DIR__ . '/../../Services/orderService.php';
require __DIR__ . '/ApiController.php';

class OrdersController extends ApiController
{
    private $orderService;

    public function __construct()
    {
        $this->orderService = new OrderService();
    }

    public function retrievePreviousOrderId(){
        try {
            $this->sendHeaders();
            $orderId=NULL;

            $orderId = $this->orderService->retrievePreviousOrderId();
            
            echo Json_encode($orderId);
        }
        catch (InvalidArgumentException|Exception $e) {
            http_response_code(500); // sending bad request error to APi request if something goes wrong
            echo $e->getMessage();
        }
    }
    
    
    
    public function addOrder()
    {
        try {
            $this->orderService->addOrder($_POST['orderId'], $_POST['userId'], $_POST['orderDate'], $_POST['billId']); 

        } catch (InvalidArgumentException | Exception $e) {
            http_response_code(500);
        }
    }

}


?>
