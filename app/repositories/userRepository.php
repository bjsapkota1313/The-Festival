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
            $stmt = $this->connection->prepare("SELECT id, firstName, lastName, dateOfBirth, email, registrationDate, picture, role,password FROM User ");
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
            $rawUser = $stmt->fetch();
            // check if the username exists in the database.
            if ($rawUser != false) {
                $user = $this->createUserInstance($rawUser);
                // echo $user->getFirstName();
                // echo $user->getEmail();
                if (password_verify($password, $user->getHashedPassword())) {
                    // to increase the security, we delete the hashed password.
                    $user->setHashedPassword("");
                    return $user;
                }
            }
            // echo "no user found";
            return null;

        } catch (Exception | PDOException $e) {
            echo $e;
        }
    }
    private function createUserInstance($dbRow): User
    {
        try {
            $user = new User();
            $user->setId($dbRow['id']);
            $user->setEmail($dbRow['email']);
            $user->setHashedPassword($dbRow['password']);
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
            $stmt = $this->connection->prepare("SELECT id, firstName, lastName, dateOfBirth, email, registrationDate, picture, role,password FROM User WHERE id = :id");
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
            $stmt = $this->connection->prepare("SELECT id, firstName, lastName, dateOfBirth, email, registrationDate, picture, role,password FROM User WHERE firstName LIKE ? OR lastName LIKE ? OR email LIKE ?");
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
            $stmt = $this->connection->prepare("SELECT id, firstName, lastName, dateOfBirth, email, registrationDate, picture, role,password FROM User ORDER BY firstName $order , lastName $order ");
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
            $stmt = $this->connection->prepare("SELECT id, firstName, lastName, dateOfBirth, email, registrationDate, picture, role,password FROM User WHERE role = :role");
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
            $stmt = $this->connection->prepare("SELECT id, firstName, lastName, dateOfBirth, email, registrationDate, picture, role,password FROM User WHERE (firstName LIKE :searchingTerm OR lastName LIKE :searchingTerm OR email LIKE :searchingTerm) AND role= :role");
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
    public function registerUser($newUser)
    {
        try {
            $stmt = $this->connection->prepare("INSERT into User (firstName, lastName, dateOfBirth, email, password, registrationDate, picturse) VALUES (:firstName, :lastName, :dateOfBirth, :email, :password, :registrationDate, :picture)");

            $stmt->bindValue(':firstName', $newUser["firstName"]);
            $stmt->bindValue(':lastName', $newUser["lastName"]);
            $stmt->bindValue(':dateOfBirth', $newUser["dateOfBirth"]);
            $stmt->bindValue(':email', $newUser["email"]);
            $stmt->bindValue(':password', $newUser['password']);
            $stmt->bindValue(':registrationDate', date("Y-m-d H:i:s"));
            $stmt->bindValue(':picture', $newUser['picture']);

            $stmt->execute();
        } catch (PDOException $e) {
            $message = '[' . date("F j, Y, g:i a e O") . ']' . $e->getMessage() . $e->getCode() . $e->getFile() . ' Line ' . $e->getLine() . PHP_EOL;
            error_log("Database connection failed: " . $message, 3, __DIR__ . "/../Errors/error.log");
            http_response_code(500);
            exit();
        }
    }

    private function checkUserExistence($stmt): bool
    {
        try {
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            $message = '[' . date("F j, Y, g:i a e O") . ']' . $e->getMessage() . $e->getCode() . $e->getFile() . ' Line ' . $e->getLine() . PHP_EOL;
            error_log("Database connection failed: " . $message, 3, __DIR__ . "/../Errors/error.log");
            http_response_code(500);
            exit();
        }
    }

    public function checkUserExistenceByEmail($email)
    {
        try {
            $stmt = $this->connection->prepare("SELECT id From User WHERE email= :email");
            $stmt->bindValue(':email', $email);
            if ($this->checkUserExistence($stmt)) {
                $stmt->execute();
                $result = $stmt->fetch();
                return $result[0];
            }
        } catch (PDOException $e) {
            $message = '[' . date("F j, Y, g:i a e O") . ']' . $e->getMessage() . $e->getCode() . $e->getFile() . ' Line ' . $e->getLine() . PHP_EOL;
            error_log("Database connection failed: " . $message, 3, __DIR__ . "/../Errors/error.log");
            http_response_code(500);
            exit();
        }
    }
//    public function getUserIdByEmail($email)
//    {
//        try {
//            $stmt = $this->connection->prepare("SELECT id From User WHERE email= :email");
//            $stmt->bindValue(':email', $email);
//            $stmt->execute();
//        } catch (PDOException $e) {
//            $message = '[' . date("F j, Y, g:i a e O") . ']' . $e->getMessage() . $e->getCode() . $e->getFile() . ' Line ' . $e->getLine() . PHP_EOL;
//            error_log("Database connection failed: " . $message, 3, __DIR__ . "/../Errors/error.log");
//            http_response_code(500);
//            exit();
//        }
//    }
    public function isTokenValid($token)
    {
        try {
//            $stmt = $this->connection->prepare("SELECT email From forgotPassword WHERE randomToken= :randomToken");
            $stmt = $this->connection->prepare("SELECT User.id
                                                        FROM User
                                                        Inner JOIN forgotPassword
                                                        ON User.id = forgotPassword.userId
                                                        WHERE forgotPassword.randomToken = :randomToken");

            $stmt->bindValue(':randomToken', $token);
            $stmt->execute();
            // Fetch the result from the executed SQL statement
            $result = $stmt->fetch();

            // Return the email address from the result
            return $result[0];

        } catch (PDOException $e) {
            echo $e;
        }
    }

    function putRandomTokenForNewPassword($token, $expiration_time, $userId)
    {
        try {
            $stmt = $this->connection->prepare("INSERT into forgotPassword (tokenExpiration, randomToken, userId) VALUES (:tokenExpiration, :randomToken, :userId)");

//            $stmt = $this->connection->prepare("UPDATE User SET randomToken = :randomToken, tokenExpiration = :tokenExpiration WHERE email = :email");

            $stmt->bindValue(':randomToken', $token);
            $stmt->bindValue(':tokenExpiration', $expiration_time);
            $stmt->bindValue(':userId', $userId);

            $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function updatePassword($userId, $newPassword)
    {
        try {
            $stmt = $this->connection->prepare("UPDATE User SET password = :password WHERE id = :id");

            $stmt->bindValue(':password', $newPassword);
            $stmt->bindValue(':id', $userId);

            $stmt->execute();
            if ($stmt->rowcount() == 0) {
                return false;
            }
            return true;

        } catch (PDOException $e) {
            echo $e;
        }
    }

    function deleteDataForgotPassword($userId, $tokenExpiration)
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM forgotPassword WHERE tokenExpiration < :tokenExpiration OR id = :id");

//            $stmt = $this->connection->prepare("UPDATE User SET password = :password WHERE email = :email");
            $stmt->bindValue(':tokenExpiration', $tokenExpiration);
            $stmt->bindValue(':id', $userId);

            $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function updateUser($connection, $id, $role, $firstName, $lastName, $dateOfBirth, $email, $picture)
    {

        $query = $connection->prepare("UPDATE User SET role=:role, firstName=:firstName, lastName=:lastName, dateOfBirth=:dateOfBirth, email=:email, picture=:picture WHERE id=:id");
        $query->bindParam(":id", $id);
        $query->bindParam(":role", $role);
        $query->bindParam(":firstName", $firstName);
        $query->bindParam(":lastName", $lastName);
        $query->bindParam(":dateOfBirth", $dateOfBirth);
        $query->bindParam(":email", $email);
        $query->bindParam(":picture", $picture);
        $query->execute();
    }

}

