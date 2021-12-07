<?php

namespace App\Exceptions;

class SolutionNotFound extends AdventOfCodeException
{
    public static function forDay(int $day, int $year): self
    {
        return new self("Day {$day} of {$year} not solved yet.");
    }
}
