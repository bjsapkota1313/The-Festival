<?php

require_once 'repository.php';

require_once __DIR__ . '/../models/ShoppingBasket.php';
require_once __DIR__ . '/../services/userService.php';



class ShoppingBasketRepository extends Repository
{

    public function getAll()
    {

        try {
            $stmt = $this->connection->prepare("SELECT * FROM shoppingbasket");
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'ShoppingBasket');
            $shoppingBaskets = $stmt->fetchAll();

            return $shoppingBaskets;

        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function retrievePreviousShoppingBasket()
    {
        try {

            $shoppingBasketsList = $this->getAll();
            $previousShoppingBasket = end($shoppingBasketsList);
            return $previousShoppingBasket;

        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function retrieveIdOfPreviousShoppingBasket()
    {

        $previousShoppingBasket = $this->retrievePreviousShoppingBasket();
        if ($previousShoppingBasket != NULL) {
            $idOfPreviousShoppingBasket = $previousShoppingBasket->getShoppingBasketId();
        } else {
            $idOfPreviousShoppingBasket = 0;
        }
        return $idOfPreviousShoppingBasket;

    }


    public function checkExistenceOfBasketForUser($userId)
    {
        $shoppingBasketExists = false;
        try {
            $shoppingBasketsList = $this->getAll();
            $userService = new UserService();
            $currentUser = $userService->getUserById($userId);
            $currentUserId = current($currentUser)->getId();
            foreach ($shoppingBasketsList as $item) {
                if ($item->getUserId() == $currentUserId) {
                    $shoppingBasketExists = true;
                } else {
                    $shoppingBasketExists = false;
                }
            }

            return $shoppingBasketExists;

        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function retrieveBasketOfUser($userId)
    {
        try {
            $shoppingBasket = new ShoppingBasket();
            $shoppingBasketsList = $this->getAll();
            foreach ($shoppingBasketsList as $item) {
                if ($item->getUserId() == $userId) {
                    $shoppingBasket = $item;

                }
            }

            return $shoppingBasket;

        } catch (PDOException $e) {
            echo $e;
        }
    }



    public function addShoppingBasket($shoppingBasketId, $userId, $billId)
    {
        $stmt = $this->connection->prepare("INSERT INTO shoppingbasket(shoppingBasketId, userId, billId)VALUES(:shoppingBasketId, :userId, :billId)");
        $stmt->bindParam(':shoppingBasketId', $shoppingBasketId);
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':billId', $billId);

        $stmt->execute();
    }
}