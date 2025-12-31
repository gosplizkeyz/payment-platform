<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $guarded = [];

    public function ledgerEntries()
    {
        return $this->hasMany(LedgerEntry::class);
    }

    public function balance(): int
    {
        return $this->ledgerEntries()
            ->selectRaw("
                SUM(
                    CASE 
                        WHEN type = 'credit' THEN amount
                        ELSE -amount
                    END
                ) as balance
            ")
            ->value('balance') ?? 0;
    }
}

