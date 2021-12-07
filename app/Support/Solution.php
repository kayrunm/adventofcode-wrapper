<?php

namespace App\Support;

use App\Exceptions\AdventOfCodeException;

abstract class Solution
{
    protected mixed $input;

    /**
     * @throws AdventOfCodeException
     */
    public function __construct(InputResolver $inputResolver)
    {
        $this->input = $this->parseInput($inputResolver->resolve($this->getDay(), $this->getYear()));
    }

    /** @return array<Result> */
    public function solve(): array
    {
        $results = [];

        foreach (['partOne', 'partTwo'] as $part) {
            $start = \microtime(true);

            $result = $this->{$part}();

            $executionTime = \microtime(true) - $start;

            $results[] = new Result($result, $executionTime);
        }

        return $results;
    }

    protected function parseInput(string $input): mixed
    {
        return $input;
    }

    abstract protected function partOne(): mixed;

    abstract protected function partTwo(): mixed;

    private function parseClass(): array
    {
        $matches = [];

        preg_match('/Year(?P<year>[0-9]{4})\\\Day(?P<day>[1-9]|1[0-9]|2[0-5])$/', get_class($this), $matches);

        return [
            'year' => $matches['year'],
            'day' => $matches['day'],
        ];
    }

    private function getDay(): int
    {
        return $this->parseClass()['day'];
    }

    private function getYear(): int
    {
        return $this->parseClass()['year'];
    }
}
