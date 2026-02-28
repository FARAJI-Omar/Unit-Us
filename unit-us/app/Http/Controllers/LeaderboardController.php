<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->input('limit', 5);
        
        $leaderboard = Profile::orderBy('points_balance', 'desc')
            ->take($limit)
            ->get(['id', 'fullname', 'points_balance']);

        return response()->json($leaderboard);
    }
}
