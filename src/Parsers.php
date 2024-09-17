<?php

namespace Gendiff\Parsers;

use Symfony\Component\Yaml\Yaml;

function parse(string $path): mixed
{
    if (!file_exists($path)) {
        throw new \Exception(sprintf("There is no any file here - %s", $path));
    }
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    $fileContent = file_get_contents($path);
    if ($fileContent === false) {
        throw new \Exception(sprintf("It's impossible to read the data on the file path %s", $path));
    }

    $object = match ($ext) {
        'json' => json_decode($fileContent, false),
        'yml', 'yaml' => Yaml::parse($fileContent, Yaml::PARSE_OBJECT_FOR_MAP),
        default => throw new \Exception(sprintf("The extension %s is not supported", $ext))
    };
    return $object;
}
