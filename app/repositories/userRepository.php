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
            if (count($rawUsers) > 0) {
                // iterate over rows of the database and convert each to a user class object.
                foreach ($rawUsers as $rawUser) {
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
        } catch (Exception|PDOException $e) {
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
            /*
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
            $users = $stmt->fetchAll();
            if (count($users) == 1) {
                $user = $users[0];
                if (password_verify($password, $user->getPassword())) {
                    return $user;
                }
            }
            return null;
            */
        } catch (Exception|PDOException $e) {
            echo $e;
        }
    }

    /**
     * @throws Exception
     */
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
            return $user;
        } catch (Exception $e) {
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
            if ($rawUser != false) {
                $user = $this->createUserInstance($rawUser);
                // to increase the security, we delete the hashed password.
                $user->setHashedPassword("");
                return $user;
            }
            return null;
        } catch (Exception|PDOException $e) {
            echo $e;
        }
        /*
        $stmt = $this->connection->prepare("SELECT * FROM User WHERE id = ?");
        $stmt->execute([$userId]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
        $users = $stmt->fetchAll();
        if (count($users) == 1) {
            return $users[0];
        }
        return null;
        */
    }

    public function registerUser($newUser)
    {
        try {
            $stmt = $this->connection->prepare("INSERT into User (firstName, lastName, dateOfBirth, email, password, registrationDate, picture) VALUES (:firstName, :lastName, :dateOfBirth, :email, :password, :registrationDate, :picture)");

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
}

