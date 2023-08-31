<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

enum ClassworkType :string  
{
    case ASSIGNMENT = 'assignment';
    case QUESTION = 'question'; 
    case MATERIAL = 'material';
} 