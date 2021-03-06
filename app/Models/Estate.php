<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'agent_id'
    ];

    public function Agent()
    {
        return $this->belongsTo('App\Models\Agent', 'agent_id');
    }
}
