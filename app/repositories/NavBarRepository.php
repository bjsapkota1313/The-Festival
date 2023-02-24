<?php
require __DIR__ . '/../models/NavBarItem.php';
require __DIR__ . '/repository.php';

class NavBarRepository extends Repository
{
    public function getAllNavBarItems()
    {
        try {
            $stmt = $this->connection->prepare("SELECT navBarItemId, pageUrl, name FROM navbar ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, 'NavBarItem');
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function updateNavBarName($navName, $navId)
    {
        try {
            $stmt = $this->connection->prepare("UPDATE navbar SET name = :name WHERE navBarItemID = :navBarItemId");

            $stmt->bindValue(':name', $navName);
            $stmt->bindValue(':navBarItemId', $navId);

            $stmt->execute();
            if ($stmt->rowcount() == 0) {
                return false;
            }
            return true;

        } catch (PDOException $e) {
            echo $e;
        }
    }

}