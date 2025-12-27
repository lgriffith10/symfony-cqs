<?php

namespace App\Enum;

enum TaskState: string
{
    case Todo = 'todo';
    case Ongoing = 'ongoing';
    case Completed = 'completed';
    case Deleted = 'deleted';
}
