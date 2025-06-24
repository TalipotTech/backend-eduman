<?php

namespace App\Enums;

enum CategoryTypeEnum: string
{
    case EVENT = 'Event';
    case BLOG = 'Blog';
    case COURSE = 'Course';
}