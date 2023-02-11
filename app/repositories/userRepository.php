<?php
require_once __DIR__ . '/repository.php';
require_once __DIR__ . '/../models/user.php';
require_once __DIR__ . '/../Models/Roles.php';

class UserRepository extends Repository
{
    function getAllUsers()
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM User");
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
            $user=$this->createUserInstance($stmt->fetch());
            echo $user->getFirstName();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
            $users = $stmt->fetchAll();
            if(count($users) == 1) {
                $user = $users[0];
                if(password_verify($password, $user->getPassword())) {
                    return $user;
                }
            }
            return null;
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
        $stmt = $this->connection->prepare("SELECT * FROM User WHERE id = ?");
        $stmt->execute([$userId]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
        $users = $stmt->fetchAll();
        if(count($users) == 1) {
            return $users[0];
        }
        return null;
    }

    function updateUser($connection, $id, $firstName, $lastName, $email, $password)
    {

        $query = $connection->prepare("UPDATE User SET firstName=:firstName, lastName=:lastname, email=:email, password=:password WHERE id=:id");
        $query->bindParam(":id", $id);
        $query->bindParam(":firstName", $firstName);
        $query->bindParam(":lastName", $lastName);
        $query->bindParam(":email", $email);
        $query->bindParam(":password", $password);
        $query->execute();
    }
}
