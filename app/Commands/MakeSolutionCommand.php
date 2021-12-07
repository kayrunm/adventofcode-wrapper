<?php

namespace App\Commands;

use App\Exceptions\AdventOfCodeException;
use App\Support\Api;
use App\Support\ParsesDayAndYear;
use App\Support\SolutionFactory;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use LaravelZero\Framework\Commands\Command;

class MakeSolutionCommand extends Command
{
    use ParsesDayAndYear;

    protected $signature = 'make {day?} {--year=} {--force}';

    protected $description = 'Create a new solution for the given day.';

    /**
     * @throws FileNotFoundException
     */
    public function handle(SolutionFactory $solutionFactory): int
    {
        try {
            [$day, $year] = $this->parseDayAndYear();

            if (! $this->option('force') && $solutionFactory->hasSolutionForDay($day, $year)) {
                throw new AdventOfCodeException("Solution for Day {$day}, {$year} already exists.");
            }

            $this->generateFile($day, $year);
            $this->downloadInput($day, $year);

            return self::SUCCESS;
        } catch (AdventOfCodeException $e) {
            $this->error($e->getMessage());

            return self::INVALID;
        }
    }

    /**
     * @throws FileNotFoundException
     */
    private function generateFile(int $day, int $year): void
    {
        $path = "Year{$year}/Day{$day}.php";

        $this->line('Creating solution file...');

        $stub = Storage::disk('stubs')->get('Solution.stub');

        $stub = (string) Str::of($stub)
            ->replace('{#YEAR#}', $year)
            ->replace('{#DAY#}', $day);

        Storage::disk('solutions')->put($path, $stub);

        $this->info("Solution for Day {$day}, {$year} successfully created.");
    }

    private function downloadInput(int $day, int $year): void
    {
        $path = "{$year}/{$day}.txt";

        $this->line('Downloading input data...');

        $data = app(Api::class)->getInputForDay($day, $year);

        Storage::disk('input')->put($path, $data);

        $this->info("Input data for Day {$day}, {$year} successfully downloaded.");
    }
}
