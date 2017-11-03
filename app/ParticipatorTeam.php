<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class ParticipatorTeam extends Model
{
    protected $fillable = ['competition_id', 'annunciator', 'clubname', 'street', 'city', 'email', 'telephone', 'resultlist'];


    public function competition()
    {
        return $this->belongsTo(Competition::class, 'competition_id');
    }

    public function Participator()
    {
        return $this->hasMany(Participator::class);
    }
}
