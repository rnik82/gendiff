<?php

namespace Differ\Differ;

use function Gendiff\Parsers\parse;
use function Gendiff\Formatters\getDiff;
// use function Gendiff\Formatters\Stylish\stylish;
// use function Gendiff\Formatters\Plain\plain;
// use function Gendiff\AstBuilder\makeAst;

// const ADDED = "+ ";
// const DELETED = "- ";
// const KEPT = "  ";

function genDiff(string $path1, string $path2, string $format = 'stylish'): string
{
    $data1 = parse($path1); // associative array
    $data2 = parse($path2); // associative array

    $dataDiff = getDiff($data1, $data2, $format);
    print_r("\n");
    print_r($dataDiff);
    print_r("\n");
    return $dataDiff;
}
