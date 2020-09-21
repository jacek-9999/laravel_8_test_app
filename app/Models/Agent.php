<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Agent extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'password', 'broker_id'
    ];

    public function estates()
    {
        return $this->hasMany('App\Models\Estate');
    }

    public function clients()
    {
        return $this->hasMany('App\Models\Client');
    }

    public function Broker()
    {
        return $this->belongsTo('App\Models\Broker', 'broker_id');
    }
}
