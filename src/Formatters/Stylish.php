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
        switch ($status) {
            case 'unchanged':
                return "{$currentIndent}  {$key}: {$valueUpd}";
            case 'updated':
                $newValue = $node['newValue'];
                $newValueUpd = is_array($newValue) ? stylish($newValue, $depth + 1)
                : $newValue;
                return "{$currentIndent}- {$key}: {$valueUpd}"
                . "\n{$currentIndent}+ {$key}: {$newValueUpd}";
            case 'removed':
                return "{$currentIndent}- {$key}: {$valueUpd}";
            case 'added':
                return "{$currentIndent}+ {$key}: {$valueUpd}";
            default:
                throw new \Exception(sprintf("There is invalid ast tree."
                . "It is imposible to find status - %s", $status));
        }
    }, $ast);

    $result = ['{', ...$lines, "{$bracketIndent}}"];
    return implode("\n", $result);
}
