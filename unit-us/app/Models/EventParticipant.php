<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventParticipant extends Model
{
    protected $connection = 'tenant';
    protected $table = 'event_participants';
    protected $fillable = ['event_id', 'profile_id', 'status'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
