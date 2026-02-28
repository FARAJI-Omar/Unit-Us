<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
    use HasFactory;

    protected $connection = 'unitus_central_db';
    
    protected $fillable = ['name', 'slug', 'db_name'];

    // One company has many users
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
