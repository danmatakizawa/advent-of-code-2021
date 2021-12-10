<?php

/**
 * Advent of Code – Day 10 Part 1
 */

require('../common.php');

// Process each line and collect the cumulative score
$score = 0;
$minion = new Minion();
$lines = loadFileIntoLines('./input.txt');
foreach($lines as $key => $line) {
    $score += $minion->processLine($line);
}
print PHP_EOL . 'PART 1 ANSWER = ' . $score . PHP_EOL;

class Minion {

    public $scoreTable = [')' => 3, ']' => 57, '}' => 1197, '>' => 25137];
    public $closerTable = [')' => '(', ']' => '[', '}' => '{', '>' => '<'];

    /**
     * Process the line, and
     * @param string $string
     * @return int
     */
    public function processLine(string $string): int {

        $context_stack = [];
        foreach(str_split($string) as $char) {

            if (array_key_exists($char, $this->closerTable)) {
                if ($context_stack[0] === $this->closerTable[$char]) {
                    array_shift($context_stack); // matching close tag. remove from context stack
                } else {
                    return $this->scoreTable[$char]; // return the score for this failure.
                }
            } else {
                array_unshift($context_stack, $char); // add to context stack
            }

        }

        return 0;

    }

}

