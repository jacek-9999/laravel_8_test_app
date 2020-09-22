<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\DB;

class Agent extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $hidden = ['password', 'remember_token'];

    protected $fillable = [
        'name', 'email', 'password', 'broker_id'
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

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

    public function scopeWithoutEstates($query)
    {
        // this probably can be better with raw query
        return $query->whereNotIn('id',
            array_values(
                array_unique(
                    DB::table('estates')
                        ->select('agent_id')
                        ->get()
                        ->map(function($el) {
                            return $el->agent_id;
                        })->toArray()
                )
            )
        );
    }
}
