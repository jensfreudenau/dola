<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $announciator
 * @property \Carbon\Carbon $created_at
 * @property int $id
 * @property \Carbon\Carbon $updated_at
 */
class Participator extends Model
{
    protected $fillable = ['prename', 'lastname', 'birthyear', 'ageclass_id', 'discipline_id', 'best_time', 'announciator_id'];

    public function Announciator()
    {
        return $this->belongsTo(Announciator::class, 'announciator_id');
    }

    public function Discipline()
    {
        return $this->belongsTo(Discipline::class, 'discipline_id');
    }

    public function Ageclass()
    {
        return $this->belongsTo(Ageclass::class, 'ageclass_id');
    }

    /**
     * Get members full name
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->prename . ' ' . $this->lastname;
    }
}
