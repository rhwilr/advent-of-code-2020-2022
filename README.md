# Advent of Code

![CI](https://github.com/rhwilr/adventOfCode/actions/workflows/ci.yml/badge.svg)


My solutions for the [Advent of Code](https://adventofcode.com) challenges.

My primary approach to the puzzles is by using TDD. I'm using 
[Laravel Zero](https://laravel-zero.com) as a base and leverage several of Laravels components. 

## Installation

```shell
composer install
```

## Running tests

```shell
phpunit

# Or running while solving the puzzle
vendor/bin/phpunit-watcher watch --filter='Tests\\Unit\\AdventOfCode2022\\Day6Test' --stop-on-fail
```
