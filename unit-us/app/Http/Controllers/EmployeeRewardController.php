<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Reward;
use App\Services\RewardService;
use Illuminate\Http\Request;

class EmployeeRewardController extends Controller
{
    public function __construct(private RewardService $rewardService) {}

    public function index(Request $request)
    {
      
        
        return response()->json($this->rewardService->getRewards());
    }

    public function purchase(Request $request, $slug, $rewardId)
    {
        $reward = Reward::findOrFail($rewardId);
        $user = $request->user();
        
        if ($user->role !== 'employee') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $profile = Profile::where('user_id', $user->id)->first();
        
        if (!$profile) {
            return response()->json(['error' => 'Profile not found'], 404);
        }

        try {
            $redemption = $this->rewardService->purchaseReward($reward, $profile->id);
            return response()->json($redemption, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function history(Request $request)
    {
        $user = $request->user();
        
        if ($user->role !== 'employee') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $profile = Profile::where('user_id', $user->id)->first();
        
        if (!$profile) {
            return response()->json(['error' => 'Profile not found'], 404);
        }

        return response()->json($this->rewardService->getPointHistory($profile->id));
    }
}
