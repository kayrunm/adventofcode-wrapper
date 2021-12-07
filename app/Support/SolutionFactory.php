<?php

namespace App\Support;


use App\Exceptions\AdventOfCodeException;
use App\Exceptions\SolutionNotFound;
use App\Solutions\AdventOfCode;

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
            throw SolutionNotFound::forDay($day, $year);
        }

        return new $class($this->inputResolver);
    }

    /** @return array<Solution> */
    public function findSolutionsForYear(int $year): array
    {
        $solutions = [];

        for ($day = 0; $day <= AdventOfCode::DAYS; $day++) {
            try {
                $solution = $this->findSolutionForDay($day, $year);

                $solutions[] = $solution;
            } catch (SolutionNotFound) {
                // This is fine, carry on.
            }
        }

        return $solutions;
    }
}
