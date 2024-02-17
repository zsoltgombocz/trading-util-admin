<?php

use App\Enums\BalanceField;
use Illuminate\Database\Migrations\Migration;
use App\Utilities\FinancialsMigrations;

return new class extends Migration
{
    use FinancialsMigrations;

    protected $tableName = 'balances';
    protected $enum = BalanceField::class;
};
