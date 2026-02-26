<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRewardRequest;
use App\Http\Requests\UpdateRewardRequest;
use App\Models\Reward;
use App\Services\RewardService;

class RewardController extends Controller
{
    public function __construct(private RewardService $rewardService) {}

    public function index()
    {
        return response()->json($this->rewardService->getAllRewards());
    }

    public function store(StoreRewardRequest $request)
    {
        $reward = $this->rewardService->createReward($request->validated());
        return response()->json($reward, 201);
    }

    public function update(UpdateRewardRequest $request, $slug, $rewardId)
    {
        $reward = Reward::findOrFail($rewardId);
        $updated = $this->rewardService->updateReward($reward, $request->validated());
        return response()->json($updated);
    }

    public function toggleAvailability($slug, $rewardId)
    {
        $reward = Reward::findOrFail($rewardId);
        $updated = $this->rewardService->toggleAvailability($reward);
        return response()->json($updated);
    }

    public function redemptionHistory()
    {
        return response()->json($this->rewardService->getRedemptionHistory());
    }
}
