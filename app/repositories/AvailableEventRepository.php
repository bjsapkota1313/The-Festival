<?php
require_once __DIR__ . '/repository.php';
require_once __DIR__ . '/../models/AvailableEvent.php';


class AvailableEventRepository extends repository
{
    public function getAvailableHistoryEvents()
    {
        try {
            $stmt = $this->connection->prepare("SELECT  eventId, eventDetails, eventTypeId,  historyTourId, eventDate, eventHour, deliveryPossibilities, singleEvent, availableTickets FROM availableevent WHERE historyTourId IS NOT NULL");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, 'AvailableEvent');
            
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function getAvailableMusicEvents()
    {
        try {
            $stmt = $this->connection->prepare("SELECT  eventId, eventDetails, eventTypeId, performanceId, CASE WHEN participatingArtistId IS NULL THEN 0 ELSE participatingArtistId END AS participatingArtistId, eventDate, eventHour, singleEvent, availableTickets FROM availableevent WHERE performanceId IS NOT NULL");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, 'AvailableEvent');
            
        } catch (PDOException $e) {
            echo $e;
        }
    }
}
