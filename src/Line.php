<?php

declare(strict_types=1);

namespace PetrHeinz\YamlTools;

final class Line
{
    /**
     * @var string
     */
    private $content;

    /**
     * @var int
     */
    private $indentationSize;

    public function __construct(string $content, int $indentationSize)
    {
        $this->content = $content;
        $this->indentationSize = $indentationSize;
    }

    public function __toString(): string
    {
        return str_repeat(' ', $this->indentationSize) . $this->content;
    }

    public static function fromString(string $string): self
    {
        $content = ltrim($string);
        $indentationSize = strlen($string) - strlen($content);

        return new self($content, $indentationSize);
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getIndentationSize(): int
    {
        return $this->indentationSize;
    }
}
