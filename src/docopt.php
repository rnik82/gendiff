<?php

namespace Gendiff\Docopt;

function assemblePath($path)
{
    if (file_exists($path)) {
        return $path;
    }
    return __DIR__ . "/../{$path}";
}

function getPathToFiles()
{
    $doc = <<<DOC

    Generate diff
  
    Usage:
      gendiff (-h|--help)
      gendiff (-v|--version)
      gendiff [--format <fmt>] <firstFile> <secondFile>
  
    Options:
      -h --help                     Show this screen
      -v --version                  Show version
      --format <fmt>                Report format [default: stylish]
  
    DOC;

    $result = \Docopt::handle($doc, array('version' => 'Naval Fate 2.0'));

    $pathToFile1 = assemblePath($result['<firstFile>']);
    $pathToFile2 = assemblePath($result['<secondFile>']);
    return [$pathToFile1, $pathToFile2];
}
