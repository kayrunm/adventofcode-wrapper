<?php

namespace App\Support;


use App\Exceptions\AdventOfCodeException;

class SolutionFactory
{
    private InputResolver $inputResolver;

    public function __construct(InputResolver $inputResolver)
    {
        $this->inputResolver = $inputResolver;
    }

    public function findSolutionForDay(int $day, int $year): Solution
    {
        if (! class_exists($class = "App\\Solutions\\Year{$year}\\Day{$day}")) {
            throw new AdventOfCodeException("Day {$day} not solved yet.");
        }

        return new $class($this->inputResolver);
    }
}
