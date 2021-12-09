/**
 * ADVENT OF CODE 2021 DAY 9 PART 1
 */

const common = require('../common.js');

function main() {
    let filename = 'input.txt';
    let mappy = new Mappy(common.loadFileIntoLines(filename));
    console.log('PART 2 OUTPUT = ', mappy.analyze());
}

class Mappy {

    constructor(lines) {
        this.width = lines[0].length;
        this.height = lines.length;
        this.lines = lines;
        this.evaluatedPoints = [];
    }

    at(x,y) {
        return parseInt(this.lines[y].charAt(x));
    }

    analyze() {

        // First generate a list of low points.
        let lowPoints = this.getLowPoints();
        let basinSizeArray = [], size;

        // Collect each basin size.
        for (let i = 0; i < lowPoints.length; i++) {
            size = this.analyzePoint(lowPoints[i]);
            basinSizeArray.push(size);
        }

        // sort the basin sizes, and grab the top 3 from the end using pop()
        basinSizeArray = basinSizeArray.sort(function (a, b) {  return a - b;  });
        return 1 * basinSizeArray.pop() * basinSizeArray.pop() * basinSizeArray.pop();

    }

    getLowPoints() {

        let lowPoints = [];

        // determine low points
        for (let x = 0; x < this.width; x++) {
            for (let y = 0; y < this.height; y++) {

                let pointVal = this.at(x,y);
                if (x > 0)                  if (pointVal >= this.at(x - 1, y)) continue;
                if (x < (this.width - 1))   if (pointVal >= this.at(x + 1, y)) continue;
                if (y > 0)                  if (pointVal >= this.at(x, y - 1)) continue;
                if (y < (this.height -1))   if (pointVal >= this.at(x, y + 1)) continue;

                // if you made it this far, it's a low point. add it to the sum
                lowPoints.push({'x':x,'y':y});
            }
        }

        return lowPoints;

    }

    analyzePoint(origin) {

        // we're doing recursion. But since we're in a class, I'm tracking state on the object in a property
        // to prevent duplication.

        if (this.evaluatedPoints[origin.x + ',' + origin.y]) return 0;
        this.evaluatedPoints[origin.x + ',' + origin.y] = true;

        let count = 1;

        let val = this.at(origin.x, origin.y);

        if (origin.x > 0) {
            let west = this.at(origin.x - 1, origin.y);
            if (west > val && west < 9) {
                count += this.analyzePoint({'x': origin.x - 1, 'y': origin.y})
            }
        }

        if (origin.x < (this.width - 1)) {
            let east = this.at(origin.x + 1, origin.y);
            if (east > val && east < 9) {
                count += this.analyzePoint({'x': origin.x + 1, 'y': origin.y})
            }
        }

        if (origin.y > 0) {
            let north = this.at(origin.x, origin.y - 1);
            if (north > val && north < 9) {
                count += this.analyzePoint({'x': origin.x, 'y': origin.y - 1})
            }
        }

        if (origin.y < (this.height - 1)) {
            let south = this.at(origin.x, origin.y + 1);
            if (south > val && south < 9) {
                count += this.analyzePoint({'x': origin.x, 'y': origin.y + 1})
            }
        }

        return count;

    }
}

// EXECUTE ME
main();


