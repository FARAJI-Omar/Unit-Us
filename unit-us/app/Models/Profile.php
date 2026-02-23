<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $connection = 'tenant';
    protected $fillable = ['user_id', 'fullname', 'points_balance'];

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_participants')
                    ->withPivot('status')
                    ->withTimestamps();
    }

    public function redemptions()
    {
        return $this->hasMany(Redemption::class);
    }

    public function pointTransactions()
    {
        return $this->hasMany(PointTransaction::class)->orderBy('created_at', 'desc');
    }
}
