<?php

namespace App\Services;

use App\Models\Reward;
use App\Models\Redemption;
use App\Models\Profile;

class RewardService
{
    public function __construct(private PointService $pointService) {}

    public function getAllRewards()
    {
        return Reward::orderBy('cost')->paginate(15);
    }

    public function createReward(array $data)
    {
        return Reward::create($data);
    }

    public function updateReward(Reward $reward, array $data)
    {
        $reward->update($data);
        return $reward;
    }

    public function toggleAvailability(Reward $reward)
    {
        $reward->update(['is_available' => !$reward->is_available]);
        return $reward;
    }

    public function getRedemptionHistory()
    {
        return Redemption::with(['profile', 'reward'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
    }

    public function getRewards()
    {
        return Reward::orderBy('cost')->paginate(10);
    }

    public function purchaseReward(Reward $reward, int $profileId)
    {
        if (!$reward->is_available) {
            throw new \Exception('Reward not available');
        }

        $profile = Profile::findOrFail($profileId);

        if ($profile->points_balance < $reward->cost) {
            throw new \Exception('Insufficient points');
        }

        $redemption = Redemption::create([
            'profile_id' => $profile->id,
            'reward_id' => $reward->id,
            'points_spent' => $reward->cost,
        ]);

        $this->pointService->deductPoints(
            $profile,
            $reward->cost,
            'spent',
            "Redeemed: {$reward->name}",
            $redemption
        );

        return $redemption->load('reward');
    }

    public function getPointHistory(int $profileId)
    {
        return Profile::findOrFail($profileId)
            ->pointTransactions()
            ->with('transactionable')
            ->paginate(10);
    }
}
