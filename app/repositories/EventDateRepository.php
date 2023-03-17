<?php
require_once __DIR__ . '/repository.php';

class EventDateRepository extends repository
{

    public function getEventDateById($id)
    {
        try {
            $stmt = $this->connection->prepare("SELECT eventDateId, date FROM eventdate WHERE eventDateId=:eventDateId");
            $stmt->bindParam(':eventDateId', $id);
            $stmt->execute();
            return current($stmt->fetchAll(PDO::FETCH_CLASS, 'EventDate'));
            
        } catch (PDOException $e) {
            echo $e;
        }
    }

}