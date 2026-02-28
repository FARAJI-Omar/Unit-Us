<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointTransaction extends Model
{
    protected $connection = 'tenant';
    protected $fillable = ['profile_id', 'type', 'amount', 'description', 'transactionable_type', 'transactionable_id'];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function transactionable()
    {
        return $this->morphTo();
    }
}
