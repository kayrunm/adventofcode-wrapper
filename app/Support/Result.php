<?php

namespace App\Support;

class Result
{
    public function __construct(
        public readonly mixed $result,
        public readonly float $executionTime,
    ) {
    }
}
