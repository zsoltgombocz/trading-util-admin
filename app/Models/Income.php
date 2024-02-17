<?php

namespace App\Models;

use App\Enums\IncomeField;

class Income extends Financial
{
    protected string $enum = IncomeField::class;
}
