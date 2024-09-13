<?php

namespace Gendiff\Formatters;

use function Gendiff\Formatters\Stylish\stylish;
use function Gendiff\Formatters\Plain\plain;
use function Gendiff\Formatters\Json\json;
use function Gendiff\AstBuilder\makeAst;

function getDiff(object $data1, object $data2, string $format): string
{
    $ast = makeAst($data1, $data2);

    return match ($format) {
        'stylish' => stylish($ast),
        'plain' => plain($ast),
        'json' => json($ast),
        default => throw new \Exception(sprintf("Unknown format - %s", $format))
    };
}
