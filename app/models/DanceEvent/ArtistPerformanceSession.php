<?php

class ArtistPerformanceSession
{
    private int $artistPerformanceSessionId;
    private string $sessionName;
    private ?string $sessionDescription;

    /**
     * @return int
     */
    public function getArtistPerformanceSessionId(): int
    {
        return $this->artistPerformanceSessionId;
    }

    /**
     * @param int $artistPerformanceSessionId
     */
    public function setArtistPerformanceSessionId(int $artistPerformanceSessionId): void
    {
        $this->artistPerformanceSessionId = $artistPerformanceSessionId;
    }

    /**
     * @return string
     */
    public function getSessionName(): string
    {
        return $this->sessionName;
    }

    /**
     * @param string $sessionName
     */
    public function setSessionName(string $sessionName): void
    {
        $this->sessionName = $sessionName;
    }

    /**
     * @return string|null
     */
    public function getSessionDescription(): ?string
    {
        return $this->sessionDescription;
    }

    /**
     * @param string|null $sessionDescription
     */
    public function setSessionDescription(?string $sessionDescription): void
    {
        $this->sessionDescription = $sessionDescription;
    } // can be null too in the database



}