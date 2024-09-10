<?php

namespace Gendiff\Engine;

use function Functional\sort;
use function Gendiff\Parsers\parse;

// const ADDED = "+ ";
// const DELETED = "- ";
// const KEPT = "  ";

function toString(mixed $value): string
{
    $string = trim(var_export($value, true), "'");
    return $string === 'NULL' ? 'null' : $string;
}

function genDiff(string $path1, string $path2, string $format = 'stylish'): string
{
    $data1 = parse($path1); // associative array
    $data2 = parse($path2); // associative array

    $dataDiff = '';
    if ($format === 'stylish') {
        $dataDiff = stylish($data1, $data2);
    }
    print_r($dataDiff);
    return $dataDiff;
}

function stylish(object $data1, object $data2, int $depth = 1): string
{
    $data1Array = get_object_vars($data1);
    $data2Array = get_object_vars($data2);
    $dataKeys1 = array_keys($data1Array);
    $dataKeys2 = array_keys($data2Array);

    $uniqueKeys = array_unique([...$dataKeys1, ...$dataKeys2]);
    $sortedKeys = sort($uniqueKeys, fn($first, $second) => $first <=> $second);

    $currentIndent = str_repeat(' ', $depth * 4 - 2); // 2 - leftOfset
    $bracketIndent = str_repeat(' ', ($depth - 1) * 4);

    $lines = array_map(function ($key) use ($data1Array, $data2Array, $currentIndent, $depth) {

        $value1 = $data1Array[$key] ?? null;
        $value2 = $data2Array[$key] ?? null;

        if (is_object($value1) &&  is_object($value2)) {
            $innerValue = stylish($value1, $value2, $depth + 1);
            $newValue = "{$currentIndent}  {$key}: {$innerValue}";
            return rtrim($newValue, " ");
        }
        if (array_key_exists($key, $data1Array) && array_key_exists($key, $data2Array)) {
            $value1Upd = is_object($value1) ? makeInner($value1, $depth + 1) : toString($value1);
            $value2Upd = is_object($value2) ? makeInner($value2, $depth + 1) : toString($value2);
            if ($value1 === $value2) {
                $newValue = "{$currentIndent}  {$key}: {$value1Upd}";
                return rtrim($newValue, " ");
            }
            if ($value1 !== $value2) {
                $newValue1 = "{$currentIndent}- {$key}: {$value1Upd}";
                $newValue2 = "\n{$currentIndent}+ {$key}: {$value2Upd}";
                return rtrim($newValue1, " ") . rtrim($newValue2, " ");
            }
        }
        if (array_key_exists($key, $data1Array)) {
            $value1Upd = is_object($value1) ? makeInner($value1, $depth + 1) : toString($value1);
            $newValue = "{$currentIndent}- {$key}: {$value1Upd}";
            return rtrim($newValue, " ");
        }
        $value2Upd = is_object($value2) ? makeInner($value2, $depth + 1) : toString($value2);
        $newValue = "{$currentIndent}+ {$key}: {$value2Upd}";
        return rtrim($newValue, " ");
    }, $sortedKeys);

    $result = ['{', ...$lines, "{$bracketIndent}}"];

    return implode("\n", $result);
}

//json_encode ?
function makeInner(object $object, int $depth): string
{
    $array = get_object_vars($object);
    $keys = array_keys($array);
    $gap = str_repeat(' ', $depth * 4);
    $gapForBracket = str_repeat(' ', ($depth - 1) * 4);
    $lines = array_map(function ($key) use ($array, $gap, $depth) {
        $value = $array[$key];
        if (is_object($value)) {
            $nested = makeInner($value, $depth + 1);
            return "{$gap}{$key}: {$nested}";
        }
        $valueToStr = toString($value);
        return "{$gap}{$key}: {$valueToStr}";
    }, $keys);
    $result = ['{', ...$lines, "{$gapForBracket}}"];
    return implode("\n", $result);
}
