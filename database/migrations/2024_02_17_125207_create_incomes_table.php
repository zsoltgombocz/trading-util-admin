<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\IncomeField;
use Illuminate\Support\Collection;
use App\Utilities\FinancialsMigrations;

return new class extends Migration
{
    use FinancialsMigrations;

    protected $tableName = 'incomes';
    protected $enum = IncomeField::class;

};
