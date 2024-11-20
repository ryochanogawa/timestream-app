<?php

namespace App\Domain\Task\ValueObjects;

enum TaskPriority: string
{
    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';

    public static function fromOrDefault(string $value): self
    {
        return self::tryFrom($value) ?? self::MEDIUM;
    }
}
