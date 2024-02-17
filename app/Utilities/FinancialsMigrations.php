<?php

namespace App\Utilities;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

trait FinancialsMigrations
{
    protected Collection $enumFields;

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        if(!property_exists($this, 'enum') || !property_exists($this, 'tableName')) {
            throw new \Exception('Must include the table name and enum to run this migration.');
        }

        $this->enumFields = collect($this->enum::asArray())->values();
    }

    public function up(): void
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stock_id');
            $table->foreign('stock_id')
                ->references('id')
                ->on('stocks')
                ->onDelete('cascade');

            $table->string('period_type');
            $table->timestamp('date');

            $this->enumFields->each(function ($fieldName)  use ($table) {
                $table->integer($fieldName)->default(0);
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->tableName);
    }
}

