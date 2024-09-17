<?php

namespace Gendiff\Formatters\Plain;

function buildPaths(array $ast, array $path = []): array
{
    $result = array_reduce($ast, function ($acc, $node) use ($path) {

        $status = $node['status'];
        $key = $node['key'];
        $value = $node['value'];

        $path = [...$path, $key];
        $currentPath = implode(".", $path);

        if ($status === 'unchanged' && is_array($value)) {
            $innerLines = buildPaths($value, $path);
            $newAcc = array_merge($acc, $innerLines);
            return $newAcc;
        }

        if ($status === 'removed') {
            $line = ["Property '{$currentPath}' was removed"];
            $newAcc = array_merge($acc, $line);
            return $newAcc;
        }

        if ($status === 'added') {
            $plainValue = getDisplayOfValue($value);
            $line = ["Property '{$currentPath}' was added with value: {$plainValue}"];
            $newAcc = array_merge($acc, $line);
            return $newAcc;
        }

        if ($status === 'updated') {
            $newValue = $node['newValue'];
            $plainValue1 = getDisplayOfValue($value);
            $plainValue2 = getDisplayOfValue($newValue);
            $line = ["Property '{$currentPath}' was updated."
            . " From {$plainValue1} to {$plainValue2}"];
            $newAcc = array_merge($acc, $line);
            return $newAcc;
        }
        return $acc;
    }, []);
    return $result;
}

function getDisplayOfValue(mixed $value): mixed
{
    $updView = is_array($value) ? '[complex value]' : $value;
    $exceptionList = ['true', 'false', 'null', '[complex value]', '0'];
    return in_array($updView, $exceptionList, true) ? $updView : "'{$updView}'";
}

function plain(array $ast): string
{
    $paths = buildPaths($ast);
    return implode("\n", $paths);
}
