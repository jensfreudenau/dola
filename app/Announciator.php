<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $participator
 * @property mixed $competition
 */
class Announciator extends Model
{
    protected $fillable = ['competition_id', 'annunciator', 'clubname', 'street', 'city', 'email', 'telephone', 'resultlist'];


    public function Competition()
    {
        return $this->belongsTo(Competition::class, 'competition_id');
    }

    public function Participator()
    {
        return $this->hasMany(Participator::class);
    }
}
