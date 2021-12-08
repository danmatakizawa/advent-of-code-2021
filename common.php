<?php

/**
 * Given a filename, we read the file, return an array of lines.
 * @param string $filename
 * @return array
 */
function loadFileIntoLines(string $filename): array
{
    $lines = [];

    $handle = fopen($filename, 'r') or die ('Error reading file.');
    while (($line = fgets($handle)) !== false) $lines[] = chop($line);
    fclose($handle);

    return $lines;
}