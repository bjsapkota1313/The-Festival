<?php

class OrderItem {
    private $quantity;
    private $ticketType;
    private $price;

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return mixed
     */
    public function getTicketType()
    {
        return $this->ticketType;
    }

    /**
     * @param mixed $ticketType
     */
    public function setTicketType($ticketType): void
    {
        $this->ticketType = $ticketType;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
    }


}
