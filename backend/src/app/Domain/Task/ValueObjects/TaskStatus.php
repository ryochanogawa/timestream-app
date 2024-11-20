<?php

// app/Domain/Task/ValueObjects/TaskStatus.php

namespace App\Domain\Task\ValueObjects;

enum TaskStatus: string
{
    case TODO = 'todo';
    case IN_PROGRESS = 'in_progress';
    case DONE = 'done';

    public static function tryFrom(string $value): ?self
    {
        return self::tryFrom($value) ?? self::TODO;
    }
}