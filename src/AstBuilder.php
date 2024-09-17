<?php

namespace Gendiff\AstBuilder;

use function Functional\sort;

function toString(mixed $value): string
{
    $string = trim(var_export($value, true), "'");
    return $string === 'NULL' ? 'null' : $string;
}

function makeAst(object $data1, object $data2): array
{
    $data1Array = get_object_vars($data1);
    $data2Array = get_object_vars($data2);
    $dataKeys1 = array_keys($data1Array);
    $dataKeys2 = array_keys($data2Array);

    $uniqueKeys = array_unique([...$dataKeys1, ...$dataKeys2]);
    $sortedKeys = sort($uniqueKeys, fn($first, $second) => $first <=> $second);

    $result = array_map(function ($key) use ($data1Array, $data2Array) {

        $value1 = $data1Array[$key] ?? null;
        $value2 = $data2Array[$key] ?? null;

        if (is_object($value1) &&  is_object($value2)) {
            $newValue = makeAst($value1, $value2);
            $node = [
                'key' => $key,
                'status' => 'unchanged',
                'value' => $newValue,
            ];
            return $node;
        }
        if (array_key_exists($key, $data1Array) && array_key_exists($key, $data2Array)) {
            $newValue1 = is_object($value1) ? getInnerObject($value1)
            : toString($value1);

            $newValue2 = is_object($value2) ? getInnerObject($value2)
            : toString($value2);

            if ($value1 === $value2) {
                $node = [
                    'key' => $key,
                    'status' => 'unchanged',
                    'value' => $newValue1,
                ];
                return $node;
            }
            if ($value1 !== $value2) {
                $node = [
                    'key' => $key,
                    'status' => 'updated',
                    'value' => $newValue1,
                    'newValue' => $newValue2
                ];
                return $node;
            }
        }
        if (array_key_exists($key, $data1Array)) {
            $newValue1 = is_object($value1) ? getInnerObject($value1)
            : toString($value1);

            $node = [
                'key' => $key,
                'status' => 'removed',
                'value' => $newValue1,
            ];
            return $node;
        }
        $newValue2 = is_object($value2) ? getInnerObject($value2)
        : toString($value2);

        $node = [
            'key' => $key,
            'status' => 'added',
            'value' => $newValue2,
        ];
        return $node;
    }, $sortedKeys);
    return $result;
}

function getInnerObject(object $object): array
{
    $array = get_object_vars($object);
    $keys = array_keys($array);
    return array_map(function ($key) use ($array) {
        $value = $array[$key];
        if (is_object($value)) {
            $nested = getInnerObject($value);
            $node = [
                'key' => $key,
                'status' => 'unchanged',
                'value' => $nested,
            ];
            return $node;
        }
        $node = [
            'key' => $key,
            'status' => 'unchanged',
            'value' => $value,
        ];
        return $node;
    }, $keys);
}
