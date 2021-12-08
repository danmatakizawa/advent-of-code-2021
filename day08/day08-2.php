<?php

/**
 * Advent of Code Day 08
 */

require('../common.php');

// load the input file into an array of strings.
$lines = loadFileIntoLines('./input.txt');

// process each line; the counter will get incremented.
$analyzer = new Analysis();

$score = 0;

foreach($lines as $line) {
    $score += $analyzer->execute($line);
}

print PHP_EOL . 'PART 2 ANSWER = ' . $score . PHP_EOL;


class Analysis {

    public function execute(string $line): int {

        // first, deconstruct.
        $tmp = explode(' | ', $line);
        $signalPatterns = explode(' ', $tmp[0]);
        $outputPatterns = explode(' ', $tmp[1]);

        // populate translation array; key is real value (a-g), value is found value(a-g)
        $t = [];
        $t['a'] = $this->_calculateA($signalPatterns);
        $t['g'] = $this->_calculateG($signalPatterns, $t['a']);
        $t['d'] = $this->_calculateD($signalPatterns, $t['a'], $t['g']);
        $t['b'] = $this->_calculateB($signalPatterns, $t['d']);
        $t['f'] = $this->_calculateF($signalPatterns, $t['a'], $t['b'], $t['d'], $t['g']);
        $t['c'] = $this->_calculateC($signalPatterns, $t['b'], $t['d'], $t['f']);
        $t['e'] = $this->_calculateE($t);

        $output = $this->_getOutput($outputPatterns, $t);
        return $output;
    }

    protected function _calculateA(array $patterns) : string
    {
        // top A segment is (segments of 7) - (segments of 1)
        $p2 = $this->_findPatternByLength($patterns, 2); // number 1 has 2 segments.
        $p3 = $this->_findPatternByLength($patterns, 3); // number 7 has 3 segments.
        $delta = $this->_delta($p2, $p3);
        return $delta['beta'][0];
    }

    protected function _calculateG(array $patterns, string $a) : string
    {
        // bottom G segment is (segments of 9) - (segments of 4 + segments of 7)
        $test = $this->_findPatternByLength($patterns, 4) . $this->_findPatternByLength($patterns, 3); // 4 has 4 segments, 7 has 3 segments.

        // go through all patterns with 6 segments, find the one with the specific difference.
        foreach($patterns as $p) {
            if (strlen($p) == 6) {
                $delta = $this->_delta($test, $p);
                if (sizeof($delta['alpha']) == 0 && sizeof($delta['beta']) == 1) {
                    return $delta['beta'][0];
                }
            }
        }
    }

    protected function _calculateD(array $patterns, string $a, string $g) : string
    {
        // middle D segment is (segments of 3) - (segments of 1 + A segment + G segment)
        $test = $this->_findPatternByLength($patterns, 2) . $a . $g;

        // go through all patterns with 5 segments, find the one with the specific difference.
        foreach($patterns as $p) {
            if (strlen($p) == 5) {
                $delta = $this->_delta($test, $p);
                if (sizeof($delta['alpha']) == 0 && sizeof($delta['beta']) == 1) {
                    return $delta['beta'][0];
                }
            }
        }
    }

    protected function _calculateB(array $patterns, string $d) : string
    {
        // top left B segment is (segments of 4) - (segments of 1 + D segment)
        $test = $this->_findPatternByLength($patterns, 2) . $d;
        $p = $this->_findPatternByLength($patterns, 4);
        $delta = $this->_delta($test, $p);
        return $delta['beta'][0];
    }

    protected function _calculateF(array $patterns, string $a, string $b, string $d, string $g) : string
    {
        // bottom right F segment is (segments of 5) - (segments A, B, D and G)
        $test = $a . $b . $d. $g;

        // go through all patterns with 5 segments, find the one with the specific difference.
        foreach($patterns as $p) {
            if (strlen($p) == 5) {
                $delta = $this->_delta($test, $p);
                if (sizeof($delta['alpha']) == 0 && sizeof($delta['beta']) == 1) {
                    return $delta['beta'][0];
                }
            }
        }
    }

    protected function _calculateC(array $patterns, string $b, string $d, string $f) : string
    {
        // top right C segment is (segments of 4) - (segments B, D, and F)
        $test = $b . $d. $f;
        $p = $this->_findPatternByLength($patterns, 4);
        $delta = $this->_delta($test, $p);
        return $delta['beta'][0];
    }

    protected function _calculateE($patterns) : string {
        // knowing all other segments, E is the last remaining segment.
        $possibleOptions = ['a','b','c','d','e','f','g'];
        foreach($possibleOptions as $x) {
            if (! in_array($x, $patterns)) return $x;
        }
    }

    protected function _findPatternByLength(array $patterns, int $length): string
    {
        foreach($patterns as $p){
            if (strlen($p) == $length) {
                return $p;
            }
        }
    }

    protected function _delta($a, $b): array{
        $a_array = str_split($a);
        $b_array = str_split($b);
        return ['alpha' => array_values(array_diff($a_array, $b_array)), 'beta' => array_values(array_diff($b_array, $a_array))];
    }

    protected function _getOutput($patterns, $t) : int
    {
        // generate the translated numbers to match against
        $match = [
            $this->_alphabetize($t['a'] . $t['b'] . $t['c'] . $t['e'] . $t['f'] . $t['g']) => 0,
            $this->_alphabetize($t['c'] . $t['f']) => 1,
            $this->_alphabetize($t['a'] . $t['c'] . $t['d'] . $t['e'] . $t['g']) => 2,
            $this->_alphabetize($t['a'] . $t['c'] . $t['d'] . $t['f'] . $t['g']) => 3,
            $this->_alphabetize($t['b'] . $t['c'] . $t['d'] . $t['f']) => 4,
            $this->_alphabetize($t['a'] . $t['b'] . $t['d'] . $t['f'] . $t['g']) => 5,
            $this->_alphabetize($t['a'] . $t['b'] . $t['d'] . $t['e'] . $t['f'] . $t['g']) => 6,
            $this->_alphabetize($t['a'] . $t['c'] . $t['f']) => 7,
            $this->_alphabetize($t['a'] . $t['b'] . $t['c'] . $t['d'] . $t['e'] . $t['f'] . $t['g']) => 8,
            $this->_alphabetize($t['a'] . $t['b'] . $t['c'] . $t['d'] . $t['f'] . $t['g']) => 9,
        ];

        // alphabetize the patterns
        foreach($patterns as $key => $pattern) {
            $patterns[$key] = $this->_alphabetize($pattern);
        }

        // now match up each piece to the match array (direct string comparison possible due to alphabetizing) and return the value.
        return 1000 * $match[$patterns[0]] + 100 * $match[$patterns[1]] + 10 * $match[$patterns[2]] + $match[$patterns[3]];
    }

    protected function _alphabetize(string $pattern): string {
        $a = str_split($pattern);
        sort($a); // unary operation
        return implode('', $a);
    }

}


