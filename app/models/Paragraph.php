<?php

class Paragraph
{
    private int $paragraphId;
    private string $title;
    private string $text;

    /**
     * @return int
     */
    public function getParagraphId(): int
    {
        return $this->paragraphId;
    }

    /**
     * @param int $paragraphId
     */
    public function setParagraphId(int $paragraphId): void
    {
        $this->paragraphId = $paragraphId;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }
}