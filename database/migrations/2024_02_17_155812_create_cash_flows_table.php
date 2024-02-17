<?php

use Illuminate\Database\Migrations\Migration;
use App\Utilities\FinancialsMigrations;
use App\Enums\CashFlowField;

return new class extends Migration
{
    use FinancialsMigrations;

    protected $tableName = 'cash_flows';
    protected $enum = CashFlowField::class;
};
