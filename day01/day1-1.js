/**
 * Advent of Code Day 1 Part 1
 */

const fs = require('fs')

let dataByLines = [];

try {
    dataByLines = fs.readFileSync('day1_input.txt','utf-8').split(/\r?\n/);
} catch(err) {
    console.error(err);
}

let prev = null, increases = 0;
dataByLines.forEach((val) => {
    val = parseInt(val); // turn into an int
    if (prev !== null && val > prev) increases++;
    prev = val;
})

console.log('increases = ', increases);