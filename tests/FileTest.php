<?php

declare(strict_types=1);

namespace PetrHeinz\YamlTools\Tests;

use PetrHeinz\YamlTools\File;
use PetrHeinz\YamlTools\Line;
use PHPUnit\Framework\TestCase;

final class FileTest extends TestCase
{
    /**
     * @return string[][]|Line[][][]
     */
    public function lineCreationProvider(): array
    {
        return [
            ['', self::createLines('')],
            ["Ͳҽʂէìղց\nմղìçօժҽ\nʂմքքօɾէ", self::createLines('Ͳҽʂէìղց', 'մղìçօժҽ', 'ʂմքքօɾէ')],
            ["👽\r😾\r💎\r🐠", self::createLines('👽', '😾', '💎', '🐠')],
            ["Trailing lines\n\n", self::createLines('Trailing lines', '', '')],
            [" \t white \t space \t ", self::createLines(" \t white \t space \t ")],
        ];
    }

    /**
     * @return string[][]
     */
    public function singleEolDetectionProvider(): array
    {
        return [
            ["Unix\nstyle", "\n"],
            ["Windows\r\nstyle", "\r\n"],
            ["Mac\rstyle", "\r"],
            ["\n", "\n"],
            ["\r\n", "\r\n"],
            ["\r", "\r"],
            ["Multi line\nmulti line", "\n"],
            ["Multi line\r\nmulti line", "\r\n"],
            ["Multi line\rmulti line", "\r"],
            ["Ŧ𝓔ร𝓽𝓲ή𝐆\nỮη𝒾𝐂Ⓞᵈ𝓔", "\n"],
            ["Ŧ𝓔ร𝓽𝓲ή𝐆\r\nỮη𝒾𝐂Ⓞᵈ𝓔", "\r\n"],
            ["Ŧ𝓔ร𝓽𝓲ή𝐆\rỮη𝒾𝐂Ⓞᵈ𝓔", "\r"],
            ["🦄\n✌", "\n"],
            ["🦄\r\n✌", "\r\n"],
            ["🦄\r✌", "\r"],
        ];
    }

    public function testDefaultEol(): void
    {
        $file = File::fromString('Text without EOL');

        $this->assertSame("\n", $file->getEol());
    }

    /**
     * @param Line[] $expectedLines
     * @dataProvider lineCreationProvider
     */
    public function testLineCreation(string $string, array $expectedLines): void
    {
        $file = File::fromString($string);

        $this->assertEquals($expectedLines, $file->toLines());
    }

    /**
     * @dataProvider singleEolDetectionProvider
     */
    public function testSingleEolDetection(string $string, string $expectedEol): void
    {
        $file = File::fromString($string);

        $this->assertSame($expectedEol, $file->getEol());
        $this->assertCount(2, $file->toLines());
    }

    /**
     * @return Line[]
     */
    private static function createLines(string ...$strings): array
    {
        return array_map(function (string $string) {
            return Line::fromString($string);
        }, $strings);
    }
}
