<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stock extends Model
{
    use HasFactory;
    protected $fillable = ['stock_name', 'company_name', 'market_cap', 'updated_at'];
    protected $dateFormat = ['updated_at'];

    /**
     * Returns all the related income data. Each income record represents one year or quarter of a year.
     * A stock has minimum of 3 of each kind (annual, quarterly) representing 3 year or 3 quarter of financial data.
     * @return HasMany
     */
    public function income()
    {
        return $this->hasMany(Income::class);
    }

    /**
     * Returns all the related income data. Each income record represents one year or quarter of a year.
     * A stock has minimum of 3 of each kind (annual, quarterly) representing 3 year or 3 quarter of financial data.
     * @return HasMany
     */
    public function balance()
    {
        return $this->hasMany(Balance::class);
    }

    /**
     * Returns all the related income data. Each income record represents one year or quarter of a year.
     * A stock has minimum of 3 of each kind (annual, quarterly) representing 3 year or 3 quarter of financial data.
     * @return HasMany
     */
    public function cash_flow()
    {
        return $this->hasMany(CashFlow::class);
    }
}
