<?php

namespace App\Enums;

enum RequestCategory: string
{
    case INFORMATION = 'informacion';
    case INCIDENT = 'incidencia';
    case DOCUMENTATION = 'documentacion';
}