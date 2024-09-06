<?php

namespace Gendiff\Parsers;

use Symfony\Component\Yaml\Yaml;

function makePath($path)
{
    if (file_exists($path)) {
        return $path;
    }
    return __DIR__ . "/../{$path}";
}

function parse($path)
{
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    $pathToFile = makePath($path);
    $fileContent = file_get_contents($pathToFile);

    $object = match ($ext) {
        'json' => json_decode($fileContent, false),
        'yml', 'yaml' => Yaml::parse($fileContent, Yaml::PARSE_OBJECT_FOR_MAP),
    };
    return get_object_vars($object);
}
