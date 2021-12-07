<?php

namespace App\Commands;

use App\Exceptions\AdventOfCodeException;
use App\Solutions\AdventOfCode;
use App\Support\ParsesDayAndYear;
use App\Support\SolutionFactory;
use LaravelZero\Framework\Commands\Command;

class SolveDayCommand extends Command
{
    use ParsesDayAndYear;

    protected $signature = 'day {day?} {--year=}';

    protected $description = 'Run the Advent of Code solutions for the given day.';

    public function handle(SolutionFactory $solutionFactory): int
    {
        try {
            [$day, $year] = $this->parseDayAndYear();

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
}
