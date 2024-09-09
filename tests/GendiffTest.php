<?php

namespace Gendiff\Tests;

use PHPUnit\Framework\TestCase;

use function Gendiff\Engine\genDiff;

class GendiffTest extends TestCase
{
    protected $expected;

    protected function setUp(): void
    {
        $this->expected = file_get_contents(realpath(__DIR__ . "/fixtures/result.txt"));
    }

    public static function extensionProvider(): array
    {
        return [
            ['json'],
            ['yaml']
        ];
    }

    /**
     * @dataProvider extensionProvider
     */

    public function testGenDiff(string $extension): void
    {
        $pathToFile1 = realpath(__DIR__ . "/fixtures/before.{$extension}");
        $pathToFile2 = realpath(__DIR__ . "/fixtures/after.{$extension}");

        $actual = genDiff($pathToFile1, $pathToFile2);

        $this->assertEquals($this->expected, $actual);
    }
}
