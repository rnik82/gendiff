<?php

namespace Gendiff\Formatters;

use function Gendiff\Formatters\Stylish\stylish;
use function Gendiff\Formatters\Plain\plain;
use function Gendiff\AstBuilder\makeAst;

function getDiff($data1, $data2, $format)
{
    $dataDiff = '';
    if ($format === 'stylish') {
        $dataDiff = stylish($data1, $data2);
    }
    if ($format === 'plain') {
        $ast = makeAst($data1, $data2);
        $dataDiff = plain($ast);
    }
    return $dataDiff;
}