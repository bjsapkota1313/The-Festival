<?php

class NavBarItem
{
    private int $navBarItemId;
    private string $pageUrl;
    private string $name;

    /**
     * @return int
     */
    public function getNavBarId(): int
    {
        return $this->navBarItemId;
    }

    /**
     * @param int $navBarItemId
     * @return self
     */
    public function setNavBarId(int $navBarItemId): self
    {
        $this->navBarItemId = $navBarItemId;
        return $this;
    }

    /**
     * @return string
     */
    public function getNavBarUrl(): string {
        return $this->pageUrl;
    }

    /**
     * @param string $pageUrl
     * @return self
     */
    public function setNavBarUrl(string $pageUrl): self {
        $this->pageUrl = $pageUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getNavName(): string {
        return $this->name;
    }

    /**
     * @param string $name
     * @return self
     */
    public function setNavName(string $name): self {
        $this->name = $name;
        return $this;
    }
}