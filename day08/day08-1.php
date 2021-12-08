<?php

/**
 * Advent of Code Day 08
 */

require('../common.php');

// load the input file into an array of strings.
$lines = loadFileIntoLines('./input.txt');
$counter = 0;

// process each line; the counter will get incremented.
foreach($lines as $line) {
    processLine($line, $counter);
}

print PHP_EOL . 'PART 1 ANSWER = ' . $counter . PHP_EOL;


/**
 * Given a line, analyzes the line and increments the counter when it finds
 * a 1,4,7, or 8 based on the number of segments
 * @param string $line
 * @param int $counter
 * @return void
 */
function processLine(string $line, int &$counter)
{
    // first, deconstruct.
    $tmp = explode(' | ', $line);
    $outputPatterns = explode(' ', $tmp[1]);

    // in the signal pattern, we want to identify which signals are the 1, 4, 7, 8.
    foreach($outputPatterns as $p) {
        switch(strlen($p)){
            case 2:
            case 3:
            case 4:
            case 7:
                $counter++;
        }
    }
}


