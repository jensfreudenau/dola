<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participator extends Model
{
    protected $fillable = ['prename', 'lastname', 'birthyear', 'age_group', 'discipline', 'best_time', 'participator_team_id'];
    
    public function ParticipatorTeam()
    {
        return $this->belongsTo(ParticipatorTeam::class, 'participator_team_id');
    }
}
