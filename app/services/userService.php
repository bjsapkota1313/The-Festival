<?php
require __DIR__ . '/../repositories/userRepository.php';
require_once __DIR__ . '/../models/user.php';

class UserService {
    // public function setReviewId(int $reviewId): self
    public function checkLogin(string $userName, string $password)
    {
        $repository = new UserRepository();
        $user = $repository->login($userName, $password);
        if(isset($user) && $user != null) {
            return $user;
        }
        return null;
    }
    public function getUserById(int $userId) {
        $repository = new UserRepository();
        return $repository->getUserById($userId);
    }
    public function getAllUsers()  {
        $repository = new UserRepository();
        return $repository->getAllUsers();
    }
    public function getUsersBySearchQuery($searchingTerm){
        $repository = new UserRepository();
        return $repository->getUsersBySearchQuery($searchingTerm);
    }
    public function getUserBySortingFirstNameByAscOrDescOrders($order)
    {
        $repository = new UserRepository();
        return $repository->getUserBySortingFirstNameByAscOrDescOrders($order);
    }
    public function getUserBySortingFirstNameByAscendingOrder(){
         return $this->getUserBySortingFirstNameByAscOrDescOrders("ASC");
    }
    public function getUserBySortingFirstNameByDescendingOrder(){
       return  $this->getUserBySortingFirstNameByAscOrDescOrders("DESC");
    }
    public function getUsersByRoles($roles){
        $repository = new UserRepository();
        return $repository->getUsersByRoles($roles);
    }
    public function getUsersBySearchAndSpecificRoles($searchingTerm, $criteria){
        $repository = new UserRepository();
        return $repository->getUsersBySearchAndSpecificRoles($searchingTerm, $criteria);
    }
    public function deleteUserById($userId) :bool{
        $repository = new UserRepository();
        return $repository->deleteUserById($userId);
    }
}
