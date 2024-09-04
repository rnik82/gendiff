<?php

namespace Gendiff\Tests;

use PHPUnit\Framework\TestCase;

use function Gendiff\Plane\genDiff;

class PlaneTest extends TestCase
{
    public function testGenDiff()
    {
        $pathToFile1 = __DIR__ . "/fixtures/file1.json";
        $pathToFile2 = __DIR__ . "/fixtures/file2.json";

        $expected = file_get_contents(__DIR__ . "/fixtures/result.txt");

        $actual = genDiff($pathToFile1, $pathToFile2);

        $this->assertEquals($expected, $actual);
    }
}