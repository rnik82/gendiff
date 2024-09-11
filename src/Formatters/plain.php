<?php

namespace Gendiff\Formatters\Plain;

function buildPaths(array $ast, array $path = []): array
{
    $result = array_reduce($ast, function ($acc, $node) use ($path) {

        $status = $node['status']; // unchanged, updated, removed, addad
        $name = $node['name'];

        $path[] = $name;
        $currentPath = implode(".", $path);

        if ($status === 'removed') {
            $line = "Property '{$currentPath}' was removed";
            print_r("!!!!!!!!!!!!!!!!!!!!!");
            print_r("\n");
            print_r(gettype($acc));
            print_r("\n");
            $acc[] = $line; // [...$acc, $line]
            return $acc;
        }

        if ($status === 'added') {
            $type = $node['type']; // complex or plain
            $value = $type === 'complex' ? '[complex value]' : $node['value'];
            $valueUpd = addApostrophes($value);
            $line = "Property '{$currentPath}' was added with value: {$valueUpd}";
            $acc[] = $line; // [...$acc, $line]
            return $acc;
        }

        if ($status === 'updated') {
            $oldType = $node['oldType'];
            $newType = $node['newType'];
            $oldValue = $oldType === 'complex' ? '[complex value]' : $node['oldValue'];
            $newValue = $newType === 'complex' ? '[complex value]' : $node['newValue'];
            $oldValueUpd = addApostrophes($oldValue);
            $newValueUpd = addApostrophes($newValue);
            $line = "Property '{$currentPath}' was updated. From {$oldValueUpd} to {$newValueUpd}";
            $acc[] = $line; // [...$acc, $line]
            return $acc;
        }

        $type = $node['type'];

        // farther unchanged cases
        if ($type === 'plain') {
            return $acc;
        }
        $innerLines = buildPaths($node['value'], $path);
        return [...$acc, ...$innerLines];
    }, []);
    return $result;
}

function addApostrophes(mixed $value): mixed
{
    $exceptionList = ['true', 'false', 'null', '[complex value]'];
    return in_array($value, $exceptionList) ? $value : "'{$value}'";
}

function plain(array $ast): string
{
    $paths = buildPaths($ast);
    return implode("\n", $paths);
}
