<?php

namespace App\Support;

use Illuminate\Config\Repository;
use Illuminate\Support\Facades\Http;

class Api
{
    private string $session;

    public function __construct(Repository $config)
    {
        $this->session = $config->get('advent-of-code.session');
    }

    public function getInputForDay(int $day, int $year): string
    {
        return Http::baseUrl('https://adventofcode.com')
            ->withCookies(['session' => $this->session], '.adventofcode.com')
            ->get("{$year}/day/{$day}/input")
            ->body();
    }
}
