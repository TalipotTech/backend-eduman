<?php

namespace App\Enums;

enum EntityTypeEnum: string
{
    case EVENT = 'Event';
    case BLOG = 'Blog';
    case COURSE = 'Course';
}