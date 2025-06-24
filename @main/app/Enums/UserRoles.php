<?php

namespace App\Enums;

enum UserRoles: string
{
    case ADMIN = 'Admin';
    case EDITOR = 'Editor';
    case MODERATOR = 'Moderator';
    case STUDENT = 'Student';
    case ACCOUNTANT = 'Accountant';
    case INSTRUCTOR = 'Instructor';
    case TEACHER = 'Teacher';
    case EXAMINER = 'Examiner';
    case SUBSCRIBE = 'Subscribe';
}
