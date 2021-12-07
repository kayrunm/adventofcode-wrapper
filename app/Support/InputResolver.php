<?php

namespace App\Support;

use App\Exceptions\AdventOfCodeException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Storage;

class InputResolver
{
    /**
     * @throws AdventOfCodeException
     */
    public function resolve(int $day, int $year): string
    {
        try {
            return Storage::disk('input')->get("{$year}/{$day}.txt");
        } catch (FileNotFoundException) {
            throw new AdventOfCodeException("Input for Year {$year}, Day {$day} not found.");
        }
    }
}
