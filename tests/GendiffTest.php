<?php

namespace Gendiff\Tests;

use PHPUnit\Framework\TestCase;

use function Gendiff\Engine\genDiff;

class GendiffTest extends TestCase
{
    private $expected;

    public function setUp(): void
    {
        $this->expected = file_get_contents(__DIR__ . "/fixtures/result.txt");
    }

    public function getFixtureFullPath($fixtureName)
    {
        $parts = [__DIR__, 'fixtures', $fixtureName];
        return realpath(implode('/', $parts));
    }

    public function testJson()
    {
        $pathToFile1 = $this->getFixtureFullPath("file1.json");
        $pathToFile2 = $this->getFixtureFullPath("file2.json");

        $actual = genDiff($pathToFile1, $pathToFile2);

        $this->assertEquals($this->expected, $actual);
    }

    public function testYaml()
    {
        $pathToFile1 = $this->getFixtureFullPath("file1.yaml");
        $pathToFile2 = $this->getFixtureFullPath("file2.yaml");

        $actual = genDiff($pathToFile1, $pathToFile2);

        $this->assertEquals($this->expected, $actual);
    }
}
