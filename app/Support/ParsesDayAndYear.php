<?php

namespace App\Support;

use App\Exceptions\AdventOfCodeException;
use App\Solutions\AdventOfCode;

trait ParsesDayAndYear
{
    /**
     * @throws AdventOfCodeException
     */
    protected function parseDayAndYear(): array
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
