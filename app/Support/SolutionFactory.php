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

    public function hasSolutionForDay(int $day, int $year): bool
    {
        return class_exists($this->getClassNameForDay($day, $year));
    }

    /**
     * @throws SolutionNotFound
     */
    public function findSolutionForDay(int $day, int $year): Solution
    {
        if (! $this->hasSolutionForDay($day, $year)) {
            throw SolutionNotFound::forDay($day, $year);
        }

        $class = $this->getClassNameForDay($day, $year);

        return new $class($this->inputResolver);
    }

    /** @return array<Solution> */
    public function findSolutionsForYear(int $year): array
    {
        $solutions = [];

        for ($day = 0; $day <= 25; $day++) {
            try {
                $solution = $this->findSolutionForDay($day, $year);

                $solutions[] = $solution;
            } catch (SolutionNotFound) {
                // This is fine, carry on.
            }
        }

        return $solutions;
    }

    public function getClassNameForDay(int $day, $year): string
    {
        return "App\\Solutions\\Year{$year}\\Day{$day}";
    }
}
