<?php

namespace Gendiff\Formatters\Stylish;

function toString(mixed $value): string
{
    $string = trim(var_export($value, true), "'");
    return $string === 'NULL' ? 'null' : $string;
}

function stylish(array $ast, int $depth = 1): string
{
    $currentIndent = str_repeat(' ', $depth * 4 - 2);
    $bracketIndent = str_repeat(' ', ($depth - 1) * 4);

    $lines = array_map(function ($node) use ($currentIndent, $depth) {

        $status = $node['status'];
        $value = $node['value'];
        $key = $node['key'];

        $valueUpd = is_array($value) ? stylish($value, $depth + 1) : $value;
        $line = '';
        switch ($status) {
            case 'unchanged':
                $line = rtrim("{$currentIndent}  {$key}: {$valueUpd}", ' ');
                break;
            case 'updated':
                $newValue = $node['newValue'];
                $newValueUpd = is_array($newValue) ? stylish($newValue, $depth + 1)
                : $newValue;
                $line = rtrim("{$currentIndent}- {$key}: {$valueUpd}", ' ')
                . rtrim("\n{$currentIndent}+ {$key}: {$newValueUpd}", ' ');
                break;
            case 'removed':
                $line = rtrim("{$currentIndent}- {$key}: {$valueUpd}", ' ');
                break;
            case 'added':
                $line = rtrim("{$currentIndent}+ {$key}: {$valueUpd}", ' ');
                break;
            default:
                throw new \Exception(sprintf("There is invalid ast tree."
                . "It is imposible to find status - %s", $status));
        }
        return $line;
    }, $ast);

    $result = ['{', ...$lines, "{$bracketIndent}}"];
    return implode("\n", $result);
}
