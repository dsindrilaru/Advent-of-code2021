<?php

$fileArr = file('input5.txt', FILE_IGNORE_NEW_LINES);

$fileArr = array_map(fn ($line) => explode(',', str_replace(' -> ', ',', $line)), $fileArr);

$fileArr = array_filter($fileArr, fn ($arr) => $arr[0] == $arr[2] || $arr[1] == $arr[3]);

$diagram = array_fill(0, 1000, array_fill(0, 1000, 0));

foreach ($fileArr as $pair) {
    if ($pair[1] == $pair[3]) {
        $start = $pair[0] < $pair[2] ? $pair[0] : $pair[2];
        $end = $pair[0] < $pair[2] ? $pair[2] : $pair[0];

        while ($start <= $end) {
            $value = $diagram[$pair[1]][$start];
            $diagram[$pair[1]][$start]++;
            $start++;
        }
    } elseif ($pair[0] == $pair[2]) {
        $start = $pair[1] < $pair[3] ? $pair[1] : $pair[3];
        $end = $pair[1] < $pair[3] ? $pair[3] : $pair[1];

        while ($start <= $end) {
            $value = $diagram[$start][$pair[0]];
            $diagram[$start][$pair[0]]++;

            $start++;
        }
    }
}

echo calculateOverlappingPoints($diagram) . PHP_EOL;

function calculateOverlappingPoints(array $diagram): int
{
    $sum = 0;
    foreach ($diagram as $row) {
        $row = array_map(fn ($val) => $val > 1 ? 1 : 0, $row);
        $sum += array_sum($row);
    }

    return $sum;
}
