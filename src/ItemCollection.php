<?php

declare(strict_types=1);

namespace PetrHeinz\YamlTools;

final class ItemCollection
{
    /**
     * @var Item[]
     */
    private $items;

    /**
     * @param Item[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @param Line[] $lines
     */
    public static function fromLines(array $lines): self
    {
        $items = [];
        $currentLines = [];
        $threshold = null;

        foreach ($lines as $line) {
            if (count($currentLines) > 0 && $line->getIndentationSize() <= $threshold) {
                $items[] = Item::fromLines($currentLines);
                $currentLines = [];
            }

            if ($threshold === null) {
                $threshold = $line->getIndentationSize();
            }

            $currentLines[] = $line;
        }
        if (count($currentLines) > 0) {
            $items[] = Item::fromLines($currentLines);
        }

        return new self($items);
    }

    public function sort(): self
    {
        $items = [];

        foreach ($this->items as $item) {
            $items[] = $item->sort();
            usort($items, function (Item $left, Item $right) {
                return strcmp($left->getName(), $right->getName());
            });
        }

        return new self($items);
    }

    /**
     * @return Line[]
     */
    public function toLines(): array
    {
        $lines = [];
        foreach ($this->items as $item) {
            $lines = array_merge($lines, $item->toLines());
        }

        return $lines;
    }
}
