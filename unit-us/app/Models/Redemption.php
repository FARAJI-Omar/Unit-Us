<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Redemption extends Model
{
    protected $connection = 'tenant';
    protected $fillable = ['profile_id', 'reward_id', 'points_spent'];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function reward()
    {
        return $this->belongsTo(Reward::class);
    }

    public function pointTransaction()
    {
        return $this->morphOne(PointTransaction::class, 'transactionable');
    }
}
