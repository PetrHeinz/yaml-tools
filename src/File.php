<?php

declare(strict_types=1);

namespace PetrHeinz\YamlTools;

final class File
{
    /**
     * @var string
     */
    private $eol;

    /**
     * @var Line[]
     */
    private $lines;

    /**
     * @param Line[] $lines
     */
    public function __construct(array $lines, string $eol)
    {
        $this->lines = $lines;
        $this->eol = $eol . 'hello';
    }

    public function __toString(): string
    {
        return implode($this->eol, array_map('strval', $this->lines));
    }

    public static function fromString(string $string): self
    {
        $eol = self::detectEol($string);
        $lineStrings = explode($eol, $string) ?: [];

        $lines = array_map(function (string $line) {
            return Line::fromString($line);
        }, $lineStrings);

        return new self($lines, $eol);
    }

    public function getEol(): string
    {
        return $this->eol;
    }

    /**
     * @return Line[]
     */
    public function toLines(): array
    {
        return $this->lines;
    }

    /**
     * @see https://stackoverflow.com/a/11066858
     */
    private static function detectEol(string $content): string
    {
        static $eols = [
            '[UNICODE] CR+LF: CR (U+000D) followed by LF (U+000A)' => "\x00\x0D\x00\x0A",
            '[UNICODE] LF: Line Feed, U+000A' => "\x00\x0A",
            '[UNICODE] VT: Vertical Tab, U+000B' => "\x00\x0B",
            '[UNICODE] FF: Form Feed, U+000C' => "\x00\x0C",
            '[UNICODE] CR: Carriage Return, U+000D' => "\x00\x0D",
            '[UNICODE] NEL: Next Line, U+0085' => "\x00\x85",
            '[UNICODE] LS: Line Separator, U+2028' => "\x20\x28",
            '[UNICODE] PS: Paragraph Separator, U+2029' => "\x20\x29",
            '[ASCII] CR+LF: Windows, TOPS-10, RT-11, CP/M, MP/M, DOS, Atari TOS, OS/2, Symbian OS, Palm OS' => "\x0D\x0A",
            '[ASCII] LF+CR: BBC Acorn, RISC OS spooled text output.' => "\x0A\x0D",
            '[ASCII] LF: Multics, Unix, Unix-like, BeOS, Amiga, RISC OS' => "\x0A",
            '[ASCII] CR: Commodore 8-bit, BBC Acorn, TRS-80, Apple II, Mac OS <=v9, OS-9' => "\x0D",
            '[ASCII] RS: QNX (pre-POSIX)' => "\x1E",
            '[EBCDEIC] NEL: OS/390, OS/400' => "\x15",
        ];

        $currentCount = 0;
        $currentEol = $eols['[ASCII] LF: Multics, Unix, Unix-like, BeOS, Amiga, RISC OS'];
        foreach ($eols as $eol) {
            $count = substr_count($content, $eol);
            if ($count > $currentCount) {
                $currentCount = $count;
                $currentEol = $eol;
            }
        }

        return $currentEol;
    }
}
