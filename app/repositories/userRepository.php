<?php
require_once __DIR__ . '/repository.php';
require_once __DIR__ . '/../models/user.php';
require_once __DIR__ . '/../Models/Roles.php';

class UserRepository extends Repository
{
    function getAllUsers()
    {
        try {
            $stmt = $this->connection->prepare("SELECT id, firstName, lastName, dateOfBirth, email, registrationDate, picture, role FROM User ");
            $stmt->execute();
            if ($stmt->rowCount() == 0) {
                return null;
            }
            $users = array();
            $result = $stmt->fetchAll();
            foreach ($result as $user) {
                $users[] = $this->createUserInstance($user);
            }
            return $users;
        } catch (PDOException|Exception $e) {
            echo $e;
        }
    }

    public function login(string $userName, string $password)
    {
        // error_log("Hashed Password: " . password_hash($password, PASSWORD_DEFAULT ) . "\n", 3, "log.txt");
        try {
            $stmt = $this->connection->prepare("SELECT * FROM User WHERE email = ?");
            $stmt->execute([$userName]);
            $user = $this->createUserInstance($stmt->fetch());
            echo $user->getFirstName();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
            $users = $stmt->fetchAll();
            if (count($users) == 1) {
                $user = $users[0];
                if (password_verify($password, $user->getPassword())) {
                    return $user;
                }
            }
            return null;
        } catch (Exception|PDOException $e) {
            echo $e;
        }
    }

    private function createUserInstance($dbRow): User
    {
        try {
            $user = new User();
            $user->setId($dbRow['id']);
            $user->setEmail($dbRow['email']);
            $user->setRegistrationDate(new DateTime($dbRow['registrationDate']));
            $user->setRole(Roles::fromString($dbRow['role']));
            $user->setDateOfBirth(new DateTime($dbRow['dateOfBirth']));
            $user->setFirstName($dbRow['firstName']);
            $user->setLastName($dbRow['lastName']);
            $user->setPicture($dbRow['picture']);
            return $user;
        } catch (Exception $e) {
            echo "Error while creating user instance: " . $e->getMessage();
        }

    }

    public function getUserById(int $userId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT id, firstName, lastName, dateOfBirth, email, registrationDate, picture, role FROM User WHERE id = :id");
            $stmt->bindParam(':id', $userId);
            $stmt->execute();
            if ($stmt->rowCount() == 0) {
                return null;
            }
            $result = $stmt->fetch();
            return $this->createUserInstance($result);
        } catch (PDOException|Exception $e) {
            echo $e;
        }
    }

    public function getUsersBySearchQuery($searchingTerm)
    {
        try {
            $stmt = $this->connection->prepare("SELECT id, firstName, lastName, dateOfBirth, email, registrationDate, picture, role FROM User WHERE firstName LIKE ? OR lastName LIKE ? OR email LIKE ?");
            $stmt->execute(["%$searchingTerm%", "%$searchingTerm%", "%$searchingTerm%"]);
            if ($stmt->rowCount() == 0) {
                return null;
            }
            $users = array();
            $result = $stmt->fetchAll();
            foreach ($result as $user) {
                $users[] = $this->createUserInstance($user);
            }
            return $users;
        } catch (PDOException|Exception $e) {
            echo $e;
        }
    }

    public function getUserBySortingFirstNameByAscOrDescOrders($order)
    {
        try {
            $stmt = $this->connection->prepare("SELECT id, firstName, lastName, dateOfBirth, email, registrationDate, picture, role FROM User ORDER BY firstName $order , lastName $order ");
            $stmt->execute();
            $users = array();
            if ($stmt->rowCount() == 0) {
                return null;
            }
            $result = $stmt->fetchAll();
            foreach ($result as $user) {
                $users[] = $this->createUserInstance($user);
            }
            return $users;
        } catch (PDOException|Exception $e) {
            echo $e;
        }
    }

    public function getUsersByRoles($role)
    {
        try {
            $stmt = $this->connection->prepare("SELECT id, firstName, lastName, dateOfBirth, email, registrationDate, picture, role FROM User WHERE role = :role");
            $stmt->bindValue(':role', Roles::getLabel($role));
            $stmt->execute();
            if ($stmt->rowCount() == 0) {
                return null;
            }
            $users = array();
            $result = $stmt->fetchAll();
            foreach ($result as $user) {
                $users[] = $this->createUserInstance($user);
            }
            return $users;
        } catch (PDOException|Exception $e) {
            echo $e;
        }
    }

    public function getUsersBySearchAndSpecificRoles($searchingTerm, $criteria)
    {
        try {
            $stmt = $this->connection->prepare("SELECT id, firstName, lastName, dateOfBirth, email, registrationDate, picture, role FROM User WHERE (firstName LIKE :searchingTerm OR lastName LIKE :searchingTerm OR email LIKE :searchingTerm) AND role= :role");
            $stmt->bindValue(':searchingTerm', "%$searchingTerm%");
            $stmt->bindValue(':role', Roles::getLabel($criteria));
            $stmt->execute();
            if ($stmt->rowCount() == 0) {
                return null;
            }
            $users = array();
            $result = $stmt->fetchAll();
            foreach ($result as $user) {
                $users[] = $this->createUserInstance($user);
            }
            return $users;
        } catch (PDOException|Exception $e) {
            echo $e;
        }
    }
    public function deleteUserById($id)
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM User WHERE id = :id");
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            if ($stmt->rowCount() == 0) {
                return false;
            }
            return true;
        } catch (PDOException|Exception $e) {
            echo $e;
        }
    }
}

