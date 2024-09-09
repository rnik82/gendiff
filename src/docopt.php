<?php

namespace Gendiff\Docopt;

use Docopt;

use function Gendiff\Engine\genDiff;

function run(): void
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

    $params = [
        'version' => '0.0.1'
    ];

    $args = Docopt::handle($doc, $params);

    genDiff($args['<firstFile>'], $args['<secondFile>'], $args['--format']);
}
