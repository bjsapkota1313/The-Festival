<?php
require_once __DIR__ . '/user.php';
class Reader extends User implements \JsonSerializable {
    private int $readerId;
    private int $readerLevel;
    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
    /**
     * Get the value of id
     *
     * @return int
     */
    public function getReaderId(): int
    {
        return $this->readerId;
    }
    /**
     * Set the value of id
     *
     * @param int $id
     *
     * @return self
     */
    public function setReaderId(int $readerId): self
    {
        $this->readerId = $readerId;
        return $this;
    }
    public function getReaderLevel(): int {
        return $this->readerLevel;
    }
}