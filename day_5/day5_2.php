<?php

$fileArr = file('input5.txt', FILE_IGNORE_NEW_LINES);

$fileArr = array_map(fn ($line) => explode(',', str_replace(' -> ', ',', $line)), $fileArr);

$diagram = array_fill(0, 1000, array_fill(0, 1000, 0));

foreach ($fileArr as $pair) {
    fillDiagram($diagram, $pair);
}

echo calculateOverlappingPoints($diagram) . PHP_EOL;

function fillDiagram(array &$diagram, array $pair): array
{
    // Horizontal line
    if ($pair[1] == $pair[3]) {
        $start = min($pair[0], $pair[2]);
        $end = max($pair[0], $pair[2]);

        while ($start <= $end) {
            $diagram[$pair[1]][$start]++;
            $start++;
        }
    } elseif ($pair[0] == $pair[2]) {
        // Vertical
        $start = min($pair[1], $pair[3]);
        $end = max($pair[1], $pair[3]);

        while ($start <= $end) {
            $diagram[$start][$pair[0]]++;

            $start++;
        }
    } else {
        // Diagonal
        $x1 = min($pair[0], $pair[2]);
        $y1 = $pair[0] > $pair[2] ? $pair[3] : $pair[1];
        $x2 = max($pair[0], $pair[2]);
        $y2 = $pair[0] > $pair[2] ? $pair[1] : $pair[3];

        while ($x1 <= $x2) {
            $diagram[$y1][$x1]++;
            $y1 += $y1 < $y2 ? 1 : -1;

            $x1++;
        }
    }

    return $diagram;
}

function calculateOverlappingPoints(array $diagram): int
{
    $sum = 0;
    foreach ($diagram as $row) {
        $row = array_map(fn ($val) => $val > 1 ? 1 : 0, $row);
        $sum += array_sum($row);
    }

    return $sum;
}
