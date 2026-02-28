<?php

namespace App\Services;

use App\Exceptions\Custom\InsufficientBalanceException;
use App\Models\Profile;
use App\Models\PointTransaction;
use Illuminate\Support\Facades\DB;

class PointService
{
    public function addPoints(Profile $profile, int $amount, string $type, string $description, $transactionable = null)
    {
        return DB::connection('tenant')->transaction(function () use ($profile, $amount, $type, $description, $transactionable) {
            $profile->increment('points_balance', $amount);
            
            return PointTransaction::create([
                'profile_id' => $profile->id,
                'type' => $type,
                'amount' => $amount,
                'description' => $description,
                'transactionable_type' => $transactionable ? get_class($transactionable) : null,
                'transactionable_id' => $transactionable?->id,
            ]);
        });
    }

    public function deductPoints(Profile $profile, int $amount, string $type, string $description, $transactionable = null)
    {
        if ($profile->points_balance < $amount) {
            throw new InsufficientBalanceException();
        }

        return DB::connection('tenant')->transaction(function () use ($profile, $amount, $type, $description, $transactionable) {
            $profile->decrement('points_balance', $amount);
            
            return PointTransaction::create([
                'profile_id' => $profile->id,
                'type' => $type,
                'amount' => -$amount,
                'description' => $description,
                'transactionable_type' => $transactionable ? get_class($transactionable) : null,
                'transactionable_id' => $transactionable?->id,
            ]);
        });
    }
}
