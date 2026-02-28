<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    protected $connection = 'tenant';
    protected $fillable = ['name', 'description', 'cost', 'is_available', 'image_url'];
    protected $casts = ['is_available' => 'boolean'];

    public function redemptions()
    {
        return $this->hasMany(Redemption::class);
    }

    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    public function scopeAffordable($query, $points)
    {
        return $query->where('cost', '<=', $points);
    }
}
