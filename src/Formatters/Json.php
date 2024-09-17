<?php

namespace Gendiff\Formatters\Json;

function json(array $ast): mixed
{
    return json_encode($ast) . PHP_EOL;
}
