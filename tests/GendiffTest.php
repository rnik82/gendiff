<?php

namespace Gendiff\Tests;

use PHPUnit\Framework\TestCase;

use function Gendiff\Engine\genDiff;

class GendiffTest extends TestCase
{
    private string $expected;

    protected function setUp(): void
    {
        $path = realpath(__DIR__ . "/fixtures/result.txt");
        if (!$path) {
            throw new \Exception("It wasn't possible to generate path to file");
        }
        $content = file_get_contents($path);
        if (!$content) {
            throw new \Exception("It wasn't possible to read the data on the file path");
        }
        $this->expected = $content;
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

        if (!$pathToFile1 || !$pathToFile2) {
            throw new \Exception("It wasn't possible to generate path to file(s)");
        }

        $actual = genDiff($pathToFile1, $pathToFile2);

        $this->assertEquals($this->expected, $actual);
    }
}
