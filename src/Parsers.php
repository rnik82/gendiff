<?php

namespace Gendiff\Parsers;

use Symfony\Component\Yaml\Yaml;

function parse(string $path): mixed
{
    // $absolutPath = __DIR__ . "/../{$path}";
    if (!file_exists($path)) {
        throw new \Exception("There is no any file here - {$path}");
    }
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    $fileContent = file_get_contents($path);
    if (!$fileContent) {
        throw new \Exception("It wasn't possible to read the data on the file path - {$path}");
    }

    $object = match ($ext) {
        'json' => json_decode($fileContent, false),
        'yml', 'yaml' => Yaml::parse($fileContent, Yaml::PARSE_OBJECT_FOR_MAP),
        default => throw new \Exception("The extension {$path} is not supported"),
    };
    return $object; // get_object_vars($object)
}
