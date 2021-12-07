<?php

namespace App\Commands;

use App\Exceptions\AdventOfCodeException;
use App\Solutions\AdventOfCode;
use App\Support\SolutionFactory;
use LaravelZero\Framework\Commands\Command;

class SingleDayCommand extends Command
{
    protected $signature = 'day {day?} {--year=}';

    protected $description = 'Run the Advent of Code solutions for the given day.';

    public function handle(SolutionFactory $solutionFactory): int
    {
        try {
            [$day, $year] = $this->parseInput();

            $this->info("Advent of Code ᐧ {$year} ᐧ Day {$day}");
            $this->newLine();

            $results = $solutionFactory->findSolutionForDay($day, $year)->solve();

            for ($i = 1; $i <= 2; $i++) {
                $result = $results[$i - 1];

                $this->line("Part {$i}: {$result->formattedAnswer()}, {$result->formattedTime()}");
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
    private function parseInput(): array
    {
        $day = (int) ($this->argument('day') ?? date('j'));
        $year = (int) ($this->option('year') ?? AdventOfCode::CURRENT_YEAR);

        if ($day < 1 || $day > AdventOfCode::DAYS) {
            throw new AdventOfCodeException('Invalid day provided.');
        }

        if ($year < AdventOfCode::LOWEST_YEAR || $year > AdventOfCode::CURRENT_YEAR) {
            throw new AdventOfCodeException('Invalid year provided.');
        }

        return [$day, $year];
    }
}
