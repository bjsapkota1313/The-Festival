<?php

class OrderItem {
    private int $orderItemId;
    private int $quantity;
    private string $ticketType;
    private string $price;
    private string $language;
    private string $foodType;
    private string $restaurantName;


    /**
     * @return int
     */
    public function getOrderItemId(): int
    {
        return $this->orderItemId;
    }

    /**
     * @param int $orderItemId
     */
    public function setOrderItemId(int $orderItemId): void
    {
        $this->orderItemId = $orderItemId;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return string
     */
    public function getTicketType(): string
    {
        return $this->ticketType;
    }

    /**
     * @param string $ticketType
     */
    public function setTicketType(string $ticketType): void
    {
        $this->ticketType = $ticketType;
    }

    /**
     * @return string
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    /**
     * @param string $price
     */
    public function setPrice(string $price): void
    {
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @param string $language
     */
    public function setLanguage(string $language): void
    {
        $this->language = $language;
    }

    /**
     * @return string
     */
    public function getFoodType(): string
    {
        return $this->foodType;
    }

    /**
     * @param string $foodType
     */
    public function setFoodType(string $foodType): void
    {
        $this->foodType = $foodType;
    }

    /**
     * @return string
     */
    public function getRestaurantName(): string
    {
        return $this->restaurantName;
    }

    /**
     * @param string $restaurantName
     */
    public function setRestaurantName(string $restaurantName): void
    {
        $this->restaurantName = $restaurantName;
    }






}
