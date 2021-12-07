<?php

namespace App\Commands;

use App\Exceptions\AdventOfCodeException;
use App\Exceptions\SolutionNotFound;
use App\Solutions\AdventOfCode;
use App\Support\ParsesDayAndYear;
use App\Support\SolutionFactory;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class MakeSolutionCommand extends Command
{
    use ParsesDayAndYear;

    protected $signature = 'make {day?} {--year=}';

    protected $description = 'Create a new solution for the given day.';

    public function handle(SolutionFactory $solutionFactory): int
    {
        try {
            [$day, $year] = $this->parseDayAndYear();

            if ($solutionFactory->hasSolutionForDay($day, $year)) {
                throw new AdventOfCodeException("Solution for Day {$day}, {$year} already exists.");
            }

            $this->generateFile($day, $year);

            $this->info("Solution for Day {$day}, {$year} created successfully.");

            return self::SUCCESS;
        } catch (AdventOfCodeException $e) {
            $this->error($e->getMessage());

            return self::INVALID;
        }
    }

    private function generateFile(int $day, int $year): void
    {
        $stub = file_get_contents(base_path('stubs/Solution.stub'));
        $stub = str_replace('{#YEAR#}', $year, $stub);
        $stub = str_replace('{#DAY#}', $day, $stub);

        if (! is_dir($dir = app_path("Solutions/Year{$year}"))) {
            mkdir($dir, 0777, true);
        }

        $file = fopen(app_path("Solutions/Year{$year}/Day{$day}.php"), 'w');
        fwrite($file, $stub);
        fclose($file);
    }
}
