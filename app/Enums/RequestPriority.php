<?php

namespace App\Enums;

enum RequestPriority: string
{
    case LOW = 'baja';
    case MEDIUM = 'media';
    case HIGH = 'alta';
}