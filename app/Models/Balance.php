<?php

namespace App\Models;

use App\Enums\BalanceField;

class Balance extends Financial
{
    protected string $enum = BalanceField::class;
}
