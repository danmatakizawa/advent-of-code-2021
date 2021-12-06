<?php

class BingoCard {

    public $numbers = [];
    public $lastNumberCalled = 0;
    public $marks = [[false,false,false,false,false],[false,false,false,false,false],[false,false,false,false,false],[false,false,false,false,false],[false,false,false,false,false]];
    public $winType = false;
    public $winId = false;

    /**
     * Reads the File Pointer, and generates an array of BingoCard objects
     * @param $fp
     * @return array
     */
    public static function generateFromFile($fp) : array
    {
        $bingoCards = [];
        $rowBuffer = [];
        while (!feof($fp)) {
            // if there's data in the row, add to the buffer as an array of integers.
            $line = trim(fgets($fp, 20));

            if (strlen($line)) {
                $row = preg_split('/ +/', $line); // split on 1 or more spaces
                foreach ($row as &$val) $val = intval($val);
                $rowBuffer[] = $row;
            }
            // Once we get five rows in the buffer, generate a new bingo card and reset the buffer
            if (sizeof($rowBuffer) == 5) {
                $bingoCards[] = new BingoCard($rowBuffer);
                $rowBuffer = [];
            }
        }
        return $bingoCards;
    }

    /**
     * BingoCard constructor.
     * @param array $numbers The numbers. expecting a 5x5 array[$row][$col]
     */
    protected function __construct(array $numbers) {
        $this->numbers = $numbers;
    }

    /**
     * Listens to a number being called, and records the mark. Returns true if it results in a win.
     * @param $number
     * @return bool
     */
    public function listen(int $number) : bool
    {
        $this->lastNumberCalled = $number;
        for ($rowNum = 0; $rowNum < 5; $rowNum++) {
            for ($colNum = 0; $colNum < 5; $colNum++) {
                if ($this->numbers[$rowNum][$colNum] == $number) {
                    $this->marks[$rowNum][$colNum] = true;
                    if ($this->didRowWin($rowNum)) {
                        $this->winType = 'row';
                        $this->winId = $rowNum;
                        return true;
                    } else if ($this->didColWin($colNum)) {
                        $this->winType = 'col';
                        $this->winId = $colNum;
                        return true;
                    } else if ($this->didDiagonal1Win()) {
                        $this->winType = 'diagonal';
                        $this->winId = 1;
                        return true;
                    } else if ($this->didDiagonal2Win()) {
                        $this->winType = 'diagonal';
                        $this->winId = 2;
                        return true;
                    }
                }
            }
        }
        return false;
    }

    /**
     * Did the row in question result in a win?
     * @param int $rowNum
     * @return bool
     */
    public function didRowWin(int $rowNum) : bool
    {
        for ($i = 0; $i < 5; $i++) {
            if ($this->marks[$rowNum][$i] !== true) return false;
        }
        return true;
    }

    /**
     * Did the column in question result in a win?
     * @param int $colNum
     * @return bool
     */
    public function didColWin(int $colNum) : bool
    {
        for ($i = 0; $i < 5; $i++) {
            if ($this->marks[$i][$colNum] !== true) return false;
        }
        return true;
    }

    /**
     * Did the diagonal from top-left to bottom-right result in a win?
     * @return bool
     */
    public function didDiagonal1Win() : bool
    {
        return $this->marks[0][0] && $this->marks[1][1] && $this->marks[2][2] && $this->marks[3][3] && $this->marks[4][4];
    }

    /**
     * Did the diagonal from top-right to bottom-left result in a win?
     * @return bool
     */
    public function didDiagonal2Win() : bool
    {
        return $this->marks[0][4] && $this->marks[1][3] && $this->marks[2][2] && $this->marks[3][1] && $this->marks[4][0];
    }

    /**
     * Calculate the score. If you haven't won, your score is 0.
     * @return int
     */
    public function getScore() : int
    {
        if ($this->winType === false) return 0;

        $sum = 0;
        for ($row = 0; $row < 5; $row++) {
            for ($col = 0; $col < 5; $col++) {
                if (! $this->marks[$row][$col]) $sum += $this->numbers[$row][$col];
            }
        }
        return $sum * $this->lastNumberCalled;

    }

    /**
     *  Generates a printout of the board in plain text.
     */
    public function print()
    {
        print "\nScore Card:\n\n";
        for ($row = 0; $row < 5; $row++) {
            for ($col = 0; $col < 5; $col++) {
                if ($this->marks[$row][$col]) {
                    print '[' . sprintf("%2d", $this->numbers[$row][$col]) . '] ';
                } else {
                    print ' ' . sprintf("%2d", $this->numbers[$row][$col]) . '  ';
                }
            }
            print "\n";
        }
    }
}