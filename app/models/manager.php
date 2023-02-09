<?php
require_once __DIR__ . '/user.php';
class Manager extends User implements \JsonSerializable {
    private int $managerId;
    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
    /**
     * Get the value of id
     *
     * @return int
     */
    public function getManagerId(): int
    {
        return $this->managerId;
    }
    /**
     * Set the value of id
     *
     * @param int $id
     *
     * @return self
     */
    public function setManagerId(int $managerId): self
    {
        $this->managerId = $managerId;
        return $this;
    }
}