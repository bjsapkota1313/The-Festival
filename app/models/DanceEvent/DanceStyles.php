<?php
class DanceStyles
{
    const TECHNO = 'Techno';
    const TRANCE = 'Trance';
    const HOUSE = 'House';
    const ELECTROHOUSE = 'Electrohouse';
    const PROGRESSIVEHOUSE = 'Progressive House';
    const MINIMAL = 'Minimal';
    const ELECTRO = 'Electro';

    private string $value;

    public function __construct(string $value)
    {
        if (!in_array($value, self::getEnumValues())) {
            throw new InvalidArgumentException("Invalid status value: $value");
        }

        $this->value = $value;
    }

    public static function TECHNO(): self
    {
        return new self(self::TECHNO);
    }

    public static function TRANCE(): self
    {
        return new self(self::TRANCE);
    }

    public static function HOUSE(): self
    {
        return new self(self::HOUSE);
    }

    public static function ELECTRO_HOUSE(): self
    {
        return new self(self::ELECTROHOUSE);
    }

    public static function PROGRESSIVE_HOUSE(): self
    {
        return new self(self::PROGRESSIVEHOUSE);
    }

    public static function MINIMAL(): self
    {
        return new self(self::MINIMAL);
    }

    public static function ELECTRO(): self
    {
        return new self(self::ELECTRO);
    }

    public static function getLabel(self $value): string
    {
        return match ($value->value) {
            self::TECHNO => 'Techno',
            self::TRANCE => 'Trance',
            self::HOUSE => 'House',
            self::ELECTROHOUSE => 'Electrohouse',
            self::PROGRESSIVEHOUSE => 'Progressive House',
            self::MINIMAL => 'Minimal',
            self::ELECTRO => 'Electro',
            default => throw new InvalidArgumentException("Invalid status value: $value"),
        };
    }

    public static function fromString(string $value): self
    {
        return match ($value) {
            self::TECHNO => self::TECHNO(),
            self::TRANCE => self::TRANCE(),
            self::HOUSE => self::HOUSE(),
            self::ELECTROHOUSE => self::ELECTRO_HOUSE(),
            self::PROGRESSIVEHOUSE => self::PROGRESSIVE_HOUSE(),
            self::MINIMAL => self::MINIMAL(),
            self::ELECTRO => self::ELECTRO(),
            default => throw new InvalidArgumentException("Invalid status value: $value"),
        };
    }

    public function jsonSerialize(): string
    {
        return $this->value;
    }

    public static function getEnumValues(): array
    {
        $reflectionClass = new ReflectionClass(__CLASS__);
        $constants = $reflectionClass->getConstants();
        return array_values($constants);
    }
}
