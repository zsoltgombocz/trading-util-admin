<?php

namespace App\Models;

use App\Enums\CashFlowField;

class CashFlow extends Financial
{
    protected string $enum = CashFlowField::class;
}
