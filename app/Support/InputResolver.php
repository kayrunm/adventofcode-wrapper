<?php

namespace App\Support;

use App\Exceptions\AdventOfCodeException;

class InputResolver
{
    /**
     * @throws AdventOfCodeException
     */
    public function resolve(int $day, int $year): string
    {
        if (! file_exists($path = base_path("input/{$year}/{$day}.txt"))) {
            throw new AdventOfCodeException("Input for Year {$year}, Day {$day} not found.");
        }

        return file_get_contents($path, FILE_IGNORE_NEW_LINES);
    }
}
