<?php
require_once __DIR__ . '/repository.php';
require_once __DIR__ . '/../models/user.php';

class UserRepository extends Repository
{
    function getAllUsers()
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM users");
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
            $users = $stmt->fetchAll();
            return $users;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function login(string $userName, string $password)
    {
        // error_log("Hashed Password: " . password_hash($password, PASSWORD_DEFAULT ) . "\n", 3, "log.txt");
        try {
            $stmt = $this->connection->prepare("SELECT * FROM User WHERE email = ?");
            $stmt->execute([$userName]);
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
            $users = $stmt->fetchAll();
            if(count($users) == 1) {
                $user = $users[0];
                if(password_verify($password, $user->getPassword())) {
                    return $user;
                }
            }
            return null;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function getUserById(int $userId)
    {
        $stmt = $this->connection->prepare("SELECT * FROM User WHERE id = ?");
        $stmt->execute([$userId]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
        $users = $stmt->fetchAll();
        if(count($users) == 1) {
            return $users[0];
        }
        return null;
    }
}

