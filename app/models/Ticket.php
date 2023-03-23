<?php
 class Ticket implements \JsonSerializable
{
    protected int $ticketId;
    protected int $availableEventId;
    protected string $ticketOptions;
    protected int $orderId;

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }

    /**
     * @return int
     */
    public function getTicketId(): int
    {
        return $this->ticketId;
    }

    /**
     * @param int $ticketId
     */
    public function setTicketId(int $ticketId): void
    {
        $this->ticketId = $ticketId;
    }

    /**
     * @return int
     */
    public function getAvailableEventId(): int
    {
        return $this->availableEventId;
    }

    /**
     * @param int $availableEventId
     */
    public function setAvailableEventId(int $availableEventId): void
    {
        $this->availableEventId = $availableEventId;
    }

    
    /**
     * @return string
     */
    public function getOptions(): string
    {
        return $this->ticketOptions;
    }

    /**
     * @param string $ticketOptions
     */
    public function setTicketOptions(string $ticketOptions): void
    {
        $this->ticketOptions = $ticketOptions;
    }

 /**
     * @return int
     */
    public function getOrderId(): int
    {
        return $this->orderId;
    }

    /**
     * @param int $orderId
     */
    public function setOrderId(int $orderId): void
    {
        $this->orderId = $orderId;
    }


}