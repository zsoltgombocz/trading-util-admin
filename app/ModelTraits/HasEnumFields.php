<?php

namespace App\ModelTraits;

use App\Enums\IncomeField;

trait HasEnumFields
{
    public static function bootHasEnumFields()
    {
        static::creating(function($model) {
            $enumValues = collect(IncomeField::asArray())->values();

            $enumValues->each(fn ($fieldName) =>  $model->makeVisible($fieldName));
        });
    }
}
