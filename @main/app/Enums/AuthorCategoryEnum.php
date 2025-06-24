<?php

namespace App\Enums;

enum AuthorCategoryEnum: string
{
    case EVENT = 'Event';
    case BLOG = 'Blog';
    case INSTRUCTOR = 'Instructor';
}