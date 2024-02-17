<?php

namespace App\Models;

use App\Enums\FinancialPeriod;
use App\ModelTraits\HasEnumFields;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Financial extends Model
{
    use HasFactory, HasEnumFields;
    protected $fillable = ['stock_id', 'period_type', 'date'];

    public $timestamps = false;

    protected $casts = [
        'period_type' => FinancialPeriod::class,
        'date' => Carbon::class
    ];

    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class);
    }
}
