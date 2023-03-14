
<?php
require_once __DIR__ . '/../models/Event.php';
require_once __DIR__ . '/../models/EventDate.php';


class AvailableEvent extends Event
{
    protected int $eventId;
    protected string $eventName;
    protected string $eventType;
    protected int $eventDate;
    protected string $eventHour;
    protected string $deliveryPossibilities;


      /**
     * @return string
     */
    public function getEventType(): string
    {
        return $this->eventType;
    }

    /**
     * @param string $eventType
     */
    public function setEventType(string $eventType): void
    {
        $this->eventType = $eventType;
    }



       /**
     * @return int
     */
    public function getEventDate(): int
    {
        return $this->eventDate;
    }

    /**
     * @param int $eventDate
     */
    public function setEventDate(int $eventDate): void
    {
        $this->eventDate= $eventDate;
    }
    
      /**
     * @return string
     */
    public function getEventHour(): string
    {
        return $this->eventHour;
    }

    /**
     * @param string $eventHour
     */
    public function setEventHour(string $eventHour): void
    {
        $this->eventHour = $eventHour;
    }

        /**
     * @return string
     */
    public function getDeliveryPossibilities(): string
    {
        return $this->deliveryPossibilities;
    }

    /**
     * @param string $deliveryPossibilities
     */
    public function setEventPossibilities(string $deliveryPossibilities): void
    {
        $this->deliveryPossibilities = $deliveryPossibilities;
    }





}