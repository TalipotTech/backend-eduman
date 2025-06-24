<?php

namespace App\Enums;

enum EventTypeEnum: string
{
    case EVENT = 'Online';
    case BLOG = 'Offline';
}