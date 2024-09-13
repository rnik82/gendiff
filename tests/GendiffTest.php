<?php

namespace Gendiff\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class GendiffTest extends TestCase
{
    private string $expectedStylish;
    private string $expectedPlain;
    private string $expectedJson;

    private function getFileContent(string $fileName): string
    {
        $path = realpath(__DIR__ . "/fixtures/{$fileName}");
        if (!$path) {
            throw new \Exception("It wasn't possible to generate path to file");
        }
        $content = file_get_contents($path);
        if (!$content) {
            throw new \Exception("It wasn't possible to read the data on the file path");
        }
        return $content;
    }

    protected function setUp(): void
    {
        $this->expectedStylish = $this->getFileContent("result-stylish.txt");
        $this->expectedPlain = $this->getFileContent("result-plain.txt");
        $this->expectedJson = $this->getFileContent("result-json.txt");
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

        $actualStylish = genDiff($pathToFile1, $pathToFile2);
        $this->assertEquals($this->expectedStylish, $actualStylish);

        $actualPlain = genDiff($pathToFile1, $pathToFile2, 'plain');
        $this->assertEquals($this->expectedPlain, $actualPlain);

        $actualJson = genDiff($pathToFile1, $pathToFile2, 'json');
        $this->assertEquals($this->expectedJson, $actualJson);
    }
}
