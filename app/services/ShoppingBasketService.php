<?php
require_once __DIR__ . '/../repositories/ShoppingBasketRepository.php';
class ShoppingBasketService
{
    private $shoppingBasketRepository;
    public function __construct()
    {
        $this->shoppingBasketRepository = new ShoppingBasketRepository();
    }

    public function getAll()
    {
        return $this->shoppingBasketRepository->getAll();
    }

    public function checkExistenceOfBasketForUser($userId)
    {
        return $this->shoppingBasketRepository->checkExistenceOfBasketForUser($userId);
    }

    public function retrieveBasketOfUser($userId)
    {
        return $this->shoppingBasketRepository->retrieveBasketOfUser($userId);
    }


    public function addShoppingBasket($shoppingBasketId, $userId, $billId)
    {
        return $this->shoppingBasketRepository->addShoppingBasket($shoppingBasketId, $userId, $billId);
    }

    public function retrievePreviousShoppingBasket()
    {
        return $this->shoppingBasketRepository->retrievePreviousShoppingBasket();
    }

    public function retrieveIdOfPreviousShoppingBasket()
    {
        return $this->shoppingBasketRepository->retrieveIdOfPreviousShoppingBasket();
    }
}