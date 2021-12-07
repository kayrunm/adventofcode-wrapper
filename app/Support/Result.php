<?php

namespace App\Support;

class Result
{
    public function __construct(
        public readonly mixed $answer,
        public readonly float $executionTime,
        public readonly mixed $correctAnswer,
    ) {
    }

    public function formattedAnswer(): string
    {
        if ($tag = $this->tag()) {
            return "<{$tag}>{$this->icon()} {$this->answer}</{$tag}>";
        }

        return $this->answer;
    }

    public function formattedTime(): string
    {
        return number_format($this->executionTime, 2) . 'µs';
    }

    private function tag(): ?string
    {
        if ($this->correctAnswer === null) {
            return null;
        }

        return $this->isCorrect() ? 'info' : 'error';
    }

    private function icon(): string
    {
        return $this->isCorrect() ? '✔' : '✘';
    }

    public function isCorrect(): bool
    {
        return $this->correctAnswer == $this->answer;
    }
}
