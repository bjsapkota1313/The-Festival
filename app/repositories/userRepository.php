<?php
require_once __DIR__ . '/repository.php';
require_once __DIR__ . '/../models/user.php';
require_once __DIR__ . '/../Models/Roles.php';

class UserRepository extends Repository
{
    // returns all users in an array. It might return empty array if there is no users in the database.
    function getAllUsers()
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM User");
            $stmt->execute();
            $rawUsers = $stmt->fetchAll();
            // create an empty array for the users object
            $users = array();
            if(count($rawUsers) > 0) {
                // iterate over rows of the database and convert each to a user class object.
                foreach($rawUsers as $rawUser) {
                    $user = $this->createUserInstance($rawUser);
                    // to increase the security, we delete the hashed password.
                    $user->setHashedPassword("");
                    // add the newly created user to the users array.
                    array_push($users, $user);
                }
            }
            // echo $users;
            // print_r($users);
            // var_dump($users);
            return $users;
        } catch (Exception | PDOException $e) {
            echo $e;
        }
        /*
        try {
            $stmt = $this->connection->prepare("SELECT * FROM users");
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
            $users = $stmt->fetchAll();
            return $users;
        } catch (PDOException $e) {
            echo $e;
        }
        */
    }

    public function login(string $userName, string $password)
    {
        // error_log("Hashed Password: " . password_hash($password, PASSWORD_DEFAULT ) . "\n", 3, "log.txt");
        try {
            $stmt = $this->connection->prepare("SELECT * FROM User WHERE email = ?");
            $stmt->execute([$userName]);
            $rawUser = $stmt->fetch();
            // check if the username exists in the database.
            if($rawUser != false) {
                $user=$this->createUserInstance($rawUser);
                // echo $user->getFirstName();
                // echo $user->getEmail();
                if(password_verify($password, $user->getHashedPassword())) {
                    // to increase the security, we delete the hashed password.
                    $user->setHashedPassword("");
                    return $user;
                }
            }
            // echo "no user found";
            return null;
            /*
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
            $users = $stmt->fetchAll();
            if(count($users) == 1) {
                $user = $users[0];
                if(password_verify($password, $user->getPassword())) {
                    return $user;
                }
            }
            return null;
            */
        } catch (Exception | PDOException $e) {
            echo $e;
        }
    }

    /**
     * @throws Exception
     */
    private function createUserInstance($dbRow) :User{
        try{
            $user = new User();
            $user->setId($dbRow['id']);
            $user->setEmail($dbRow['email']);
            $user->setHashedPassword($dbRow['password']);
            $user->setRegistrationDate(new DateTime($dbRow['registrationDate']));
            $user->setRole(Roles::fromString($dbRow['role']));
            $user->setDateOfBirth(new DateTime($dbRow['dateOfBirth']));
            $user->setFirstName($dbRow['firstName']);
            $user->setLastName($dbRow['lastName']);
            return $user;
        }
        catch (Exception $e){
            echo "Error while creating user instance: " . $e->getMessage();
        }

    }

    public function getUserById(int $userId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM User WHERE id = ?");
            $stmt->execute([$userId]);
            $rawUser = $stmt->fetch();
            // check if the userId exists in the database.
            if($rawUser != false) {
                $user=$this->createUserInstance($rawUser);
                // to increase the security, we delete the hashed password.
                $user->setHashedPassword("");
                return $user;
            }
            return null;
        } catch (Exception | PDOException $e) {
            echo $e;
        }
        /*
        $stmt = $this->connection->prepare("SELECT * FROM User WHERE id = ?");
        $stmt->execute([$userId]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
        $users = $stmt->fetchAll();
        if(count($users) == 1) {
            return $users[0];
        }
        return null;
        */
    }
}

