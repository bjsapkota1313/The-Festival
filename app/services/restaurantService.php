<?php
require __DIR__ . '/../repositories/restaurantRepository.php';
require_once __DIR__ . '/../models/restaurant.php';

class RestaurantService
{
    
    public function deleteRestaurantById(int $restaurantID)
    {
        $repository = new RestaurantRepository();
        return $repository->deleteRestaurantById($restaurantID);
    }
    public function getRestaurantByName(string $restaurantName)
    {
        $repository = new RestaurantRepository();
        return $repository->getRestaurantByName($restaurantName);
    }
    public function getRestaurants()
    {
        $repository = new RestaurantRepository();
        return $repository->getRestaurants();
    }


    public function createNewRestaurant($newRestaurant): void
    {
        $repository = new RestaurantRepository();
        $repository->createNewRestaurant($newRestaurant);
    }

    public function updateRestaurantById($restaurantID, $newRestaurant): void 
    {
        $repository = new RestaurantRepository();
        $repository->updateRestaurantById($restaurantID, $newRestaurant);
    }

    public function deletePageById($pageID): void 
    {
        $repository = new PageRepository();
        $repository->deletePageById($pageID);
    }
}
