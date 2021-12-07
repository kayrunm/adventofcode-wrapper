<?php

namespace App\Commands;

use App\Exceptions\AdventOfCodeException;
use App\Solutions\AdventOfCode;
use App\Support\SolutionFactory;
use LaravelZero\Framework\Commands\Command;
use OutOfRangeException;

class SolveYearCommand extends Command
{
    protected $signature = 'year {year?}';

    protected $description = 'Run all Advent of Code solutions for the given year.';

    public function handle(SolutionFactory $solutionFactory): int
    {
        try {
            $year = $this->parseInput();

            $this->info("Advent of Code ᐧ {$year}");

            foreach($solutionFactory->findSolutionsForYear($year) as $i => $solution) {
                $day = $i + 1;
                $results = $solution->solve();

                $this->newLine();
                $this->info("Day {$day}");

                for ($part = 1; $part <= 2; $part++) {
                    $result = $results[$part - 1];

                    $this->line("  Part {$part}: {$result->formattedAnswer()}, {$result->formattedTime()}");
                }
            }

            return self::SUCCESS;
        } catch (AdventOfCodeException $e) {
            $this->error($e->getMessage());

            return self::INVALID;
        }
    }

    /**
     * @throws AdventOfCodeException
     */
    private function parseInput(): int
    {
        $year = (int) ($this->argument('year') ?? AdventOfCode::CURRENT_YEAR);

        if ($year < AdventOfCode::LOWEST_YEAR || $year > AdventOfCode::CURRENT_YEAR) {
            throw new AdventOfCodeException('Invalid year provided.');
        }

        return $year;
    }
}
