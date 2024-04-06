<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClosedTrades extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock', 'open_positions', 'note', 'buy_occurred_at', 'sell_occurred_at'
    ];

    protected $casts = [
        'buy_occurred_at' => 'datetime',
        'sell_occurred_at' => 'datetime',
    ];

    public function getActiveDaysAttribute(): int
    {
        if($this->buy_occurred_at && $this->sell_occurred_at) {
            return $this->buy_occurred_at->diffIndays($this->sell_occurred_at);
        }

        return 0;
    }
}
