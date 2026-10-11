<?php

namespace App\Enum;

enum UserRole: string
{
    case Admin = 'admin';
    case Author = 'author';
}
