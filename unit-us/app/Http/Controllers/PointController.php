<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdjustPointsRequest;
use App\Models\Profile;
use App\Services\PointService;

class PointController extends Controller
{
    public function __construct(private PointService $pointService) {}

    public function adjust(AdjustPointsRequest $request, $slug, $profileId)
    {
        $profile = Profile::findOrFail($profileId);
        $amount = $request->validated()['amount'];
        $reason = $request->validated()['reason'];

        if ($amount > 0) {
            $this->pointService->addPoints($profile, $amount, 'bonus', $reason);
        } else if ($amount < 0) {
            $this->pointService->deductPoints($profile, abs($amount), 'deduction', $reason);
        }

        return response()->json([
            'message' => 'Points adjusted successfully',
            'profile' => $profile->fresh(),
        ]);
    }
}
