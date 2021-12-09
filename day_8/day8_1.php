<?php

$fileArr = file('input8.txt', FILE_IGNORE_NEW_LINES);

$signals = array_map(fn ($entry) => explode(' ', explode('|', $entry)[1]), $fileArr);

$instances = array_map(function ($arr) {
    return array_sum(array_map(fn ($val) => in_array(strlen($val), [2, 3, 4, 7]) ? 1 : 0, $arr));
}, $signals);

echo array_sum($instances) . PHP_EOL;