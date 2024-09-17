<?php

namespace Differ\Differ;

use function Gendiff\Parsers\parse;
use function Gendiff\Formatters\getDiff;

function genDiff(string $path1, string $path2, string $format = 'stylish'): string
{
    $data1 = parse($path1);
    $data2 = parse($path2);

    $dataDiff = getDiff($data1, $data2, $format);
    echo $dataDiff;
    return $dataDiff;
}
