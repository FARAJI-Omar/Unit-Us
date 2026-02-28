<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $connection = 'tenant';
    protected $fillable = ['title', 'description', 'location', 'date', 'points_reward', 'capacity', 'status'];
    protected $casts = ['date' => 'datetime'];

    public function participants()
    {
        return $this->belongsToMany(Profile::class, 'event_participants')
                    ->withPivot('status')
                    ->withTimestamps();
    }

    public function pointTransactions()
    {
        return $this->morphMany(PointTransaction::class, 'transactionable');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('date', '>', now())->where('status', 'open');
    }

    public function isFull()
    {
        if (!$this->capacity) return false;
        return $this->participants()->wherePivot('status', '!=', 'cancelled')->count() >= $this->capacity;
    }
}
