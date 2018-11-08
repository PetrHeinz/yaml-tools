<?php

declare(strict_types=1);

namespace PetrHeinz\YamlTools;

final class Item
{
    /**
     * @var ItemCollection
     */
    private $itemCollection;

    /**
     * @var Line
     */
    private $line;

    public function __construct(Line $line, ItemCollection $itemCollection)
    {
        $this->line = $line;
        $this->itemCollection = $itemCollection;
    }

    /**
     * @param Line[] $lines
     */
    public static function fromLines(array $lines): self
    {
        $firstLine = array_shift($lines);
        if ($firstLine === null) {
            throw new \InvalidArgumentException('No lines provided.');
        }

        return new self($firstLine, ItemCollection::fromLines($lines));
    }

    public function getName(): string
    {
        return $this->line->getContent();
    }

    public function sort(): self
    {
        return new self($this->line, $this->itemCollection->sort());
    }

    /**
     * @return Line[]
     */
    public function toLines(): array
    {
        return array_merge([$this->line], $this->itemCollection->toLines());
    }
}
