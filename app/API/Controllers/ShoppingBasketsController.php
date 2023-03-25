<?php
require __DIR__ . '/../../Services/ShoppingBasketService.php';
require __DIR__ . '/ApiController.php';

class ShoppingBasketsController extends ApiController
{
    private $shoppingBasketService;

    public function __construct()
    {
        $this->shoppingBasketService = new ShoppingBasketService();
    }

    public function retrievePreviousShoppingBasketId()
    {
        try {
            $this->sendHeaders();
            $shoppingBasketId = NULL;

            $shoppingBasketId = $this->shoppingBasketService->retrieveIdOfPreviousShoppingBasket();

            echo Json_encode($shoppingBasketId);
        } catch (InvalidArgumentException | Exception $e) {
            http_response_code(500); // sending bad request error to APi request if something goes wrong
            echo $e->getMessage();
        }
    }



    public function addShoppingBasket()
    {
        try {
            $this->shoppingBasketService->addShoppingBasket($_POST['shoppingBasketId'], $_POST['userId'], $_POST['billId']);

        } catch (InvalidArgumentException | Exception $e) {
            http_response_code(500);
        }
    }


}


?>