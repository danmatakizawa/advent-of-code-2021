#
# Advent of Code Day 5
#

import re

#
#
#
def main():
    # load instructions into a file
    with open('./input.txt') as inputfile:
        lines = inputfile.readlines()

    # crush instructions into meaningful data.
    instructions = []
    for (line) in lines:
        matches = re.match(r'([0-9]+),([0-9]+) \-\> ([0-9]+),([0-9]+)', line.rstrip()).groups()
        instructions.append({ 'x1': matches[0], 'y1': matches[1], 'x2': matches[2], 'y2': matches[3]})

    # generate the hitmap we will fill in
    # TODO: Learn how to deal with this properly, this is slow and wasteful
    hitmap = initialize_hitmap(1000, 1000)

    # loop through instructions. determine if
    for (instruction) in instructions:
        execute_instruction(instruction, hitmap)

    # print out the hitmap
    print_hitmap(hitmap)


#
# Initialize the hitmap as a 2 dimensional array of 0s
#
def initialize_hitmap(width, height):
    return [[0 for i in range(0, width)] for j in range(0, height)]

#
# Given an instruction, apply it to the hitmap
#
def execute_instruction(i, hitmap):
    # print()

    # we only expect horizontal and vertical lines so it's either one or the other.

    if i['x1'] != i['x2'] and i['y1'] != i['y2']:
        # diagonal line
        x_start = int(i['x1'])
        x_end = int(i['x2'])
        y_start = int(i['y1'])
        y_end = int(i['y2'])
        for c in range(0, (1 + abs(x_start - x_end))):
            if x_start < x_end:
                x = x_start + c
            else:
                x = x_start - c

            if y_start < y_end:
                y = y_start + c
            else:
                y = y_start - c
            hitmap[x][y] += 1

    elif i['x1'] != i['x2']:
        # horizontal line
        x_min = min(int(i['x1']), int(i['x2']))
        x_max = max(int(i['x1']), int(i['x2']))
        y = int(i['y1'])
        for x in range(x_min, x_max + 1):
            hitmap[x][y] += 1

    else:
        #vertical line
        y_min = min(int(i['y1']), int(i['y2']))
        y_max = max(int(i['y1']), int(i['y2']))
        x = int(i['x1'])
        for y in range(y_min, y_max + 1):
            hitmap[x][y] += 1

#
# Prints out the hitmap
#
def print_hitmap(m):

    width = len(m)
    height = len(m[0])

    score = 0

    print('hitmap is width ' + str(width) + ' height ' + str(height))
    print('')

    for y in range(height):
        for x in range(width):
            # print str(x) + ',' + str(y) + ' = ' + str(m[x][y])
            if m[x][y] > 0:
                print(str(m[x][y]), end='')
            else:
                print('.', end='')

            if m[x][y] > 1:
                score += 1
        print('')

    print('')
    print('SCORE = ' + str(score))


#
# RUN IT
#
main()
