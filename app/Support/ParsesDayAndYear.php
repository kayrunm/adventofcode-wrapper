<?php

namespace App\Support;

use App\Exceptions\AdventOfCodeException;

trait ParsesDayAndYear
{
    /**
     * @throws AdventOfCodeException
     */
    protected function parseDayAndYear(): array
    {
        $day = (int) ($this->argument('day') ?? date('j'));
        $year = (int) ($this->option('year') ?? config('advent-of-code.years.current'));

        if ($day < 1 || $day > 25) {
            throw new AdventOfCodeException('Invalid day provided.');
        }

        if ($year < config('advent-of-code.years.lowest') || $year > config('advent-of-code.years.current')) {
            throw new AdventOfCodeException('Invalid year provided.');
        }

        return [$day, $year];
    }
}
