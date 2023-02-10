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
}
