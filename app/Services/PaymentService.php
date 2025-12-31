<?php

namespace App\Services;

use App\Models\Business;
use App\Models\Wallet;
use App\Models\LedgerEntry;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentService
{
    const PLATFORM_FEE_PERCENT = 2.5;
    const TAX_PERCENT = 7.5;

    public function process(Business $business, int $amount)
    {
        return DB::transaction(function () use ($business, $amount) {

            $reference = Str::uuid();

            $platformFee = (int) round($amount * self::PLATFORM_FEE_PERCENT / 100);
            $tax = (int) round($amount * self::TAX_PERCENT / 100);
            $netAmount = $amount - $platformFee - $tax;

            $businessWallet = Wallet::where('owner_type', 'business')
                ->where('owner_id', $business->id)
                ->lockForUpdate()
                ->firstOrFail();

            $platformWallet = Wallet::where('owner_type', 'platform')
                ->lockForUpdate()
                ->firstOrFail();

            $taxWallet = Wallet::where('owner_type', 'tax')
                ->lockForUpdate()
                ->firstOrFail();

            LedgerEntry::insert([
                [
                    'wallet_id' => $businessWallet->id,
                    'reference' => $reference,
                    'type' => 'credit',
                    'amount' => $netAmount,
                    'description' => 'Customer payment',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'wallet_id' => $platformWallet->id,
                    'reference' => $reference,
                    'type' => 'credit',
                    'amount' => $platformFee,
                    'description' => 'Platform fee',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'wallet_id' => $taxWallet->id,
                    'reference' => $reference,
                    'type' => 'credit',
                    'amount' => $tax,
                    'description' => 'VAT',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);

            Payment::create([
                'reference' => $reference,
                'business_id' => $business->id,
                'amount' => $amount,
                'status' => 'successful',
            ]);

            return $reference;
        });
    }
}
