<?php

namespace App\Enums;

enum StatusEnum: string
{
    case PENDING = 'Pending';
    case ACTIVE = 'Active';
    case INACTIVE = 'Inactive';
    case APPROVED = 'Approved';
}