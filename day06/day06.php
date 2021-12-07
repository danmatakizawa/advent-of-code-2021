<?php

$inputString = '3,5,3,1,4,4,5,5,2,1,4,3,5,1,3,5,3,2,4,3,5,3,1,1,2,1,4,5,3,1,4,5,4,3,3,4,3,1,1,2,2,4,1,1,4,3,4,4,2,4,3,1,5,1,2,3,2,4,4,1,1,1,3,3,5,1,4,5,5,2,5,3,3,1,1,2,3,3,3,1,4,1,5,1,5,3,3,1,5,3,4,3,1,4,1,1,1,2,1,2,3,2,2,4,3,5,5,4,5,3,1,4,4,2,4,4,5,1,5,3,3,5,5,4,4,1,3,2,3,1,2,4,5,3,3,5,4,1,1,5,2,5,1,5,5,4,1,1,1,1,5,3,3,4,4,2,2,1,5,1,1,1,4,4,2,2,2,2,2,5,5,2,4,4,4,1,2,5,4,5,2,5,4,3,1,1,5,4,5,3,2,3,4,1,4,1,1,3,5,1,2,5,1,1,1,5,1,1,4,2,3,4,1,3,3,2,3,1,1,4,4,3,2,1,2,1,4,2,5,4,2,5,3,2,3,3,4,1,3,5,5,1,3,4,5,1,1,3,1,2,1,1,1,1,5,1,1,2,1,4,5,2,1,5,4,2,2,5,5,1,5,1,2,1,5,2,4,3,2,3,1,1,1,2,3,1,4,3,1,2,3,2,1,3,3,2,1,2,5,2';

$reportDays = [80, 256];
$endDay = 256;

// Get the initial graph array
$graph = initializeGraph($inputString);

for ($day = 1; $day <= $endDay; $day++) {

    // time down every item, which means moving the value into the index below.
    for($i = 0; $i <= 8; $i++) {
        $graph[$i - 1] = $graph[$i];
    }

    // handle spawning.
    $graph[6] += $graph[-1]; // everything in -1 resets to 6
    $graph[8] = $graph[-1];  // ... and also puts a new one into 8!
    $graph[-1] = 0;          // empty the spawning spot

    // print report on relevant days.
    if (in_array($day, $reportDays)) {
        print 'TOTAL FISH AFTER ' . $day . ' DAYS = '. array_sum($graph) . PHP_EOL;
    }
}


/**
 * @return array
 */
function initializeGraph(string $inputString): array
{
    // initialize the graph
    $graph = [];
    for ($day = -1; $day <= 8; $day++) {
        $graph[$day] = 0;
    }

    // populate from input string.
    $input = explode(',',$inputString);
    foreach($input as $val) {
        $graph[intval($val)]++;
    }

    return $graph;
}