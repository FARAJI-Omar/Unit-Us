<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable; 
    
    /**
     * Force the User model to always use the central database.
     * This is crucial for multi-tenancy.
     */
    protected $connection = 'unitus_central_db';

    protected $fillable = [
        'email', 
        'fullname',
        'password', 
        'role', 
        'entreprise_id'
    ];

    protected $hidden = [
        'password', 
        'remember_token'
    ];

    /**
     * User belongs to an entreprise (lives in Central DB)
     */
    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }
}