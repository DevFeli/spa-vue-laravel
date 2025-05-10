<?php

namespace App\Enums;

enum ActionType: string
{
    case CREATE = 'create';
    case EDIT = 'edit';
    case DELETE = 'delete';
}