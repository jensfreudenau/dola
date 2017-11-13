<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $announciator
 * @property \Carbon\Carbon $created_at
 * @property int $id
 * @property \Carbon\Carbon $updated_at
 */
class Participator extends Model
{
    protected $fillable = ['prename', 'lastname', 'birthyear', 'age_group', 'discipline', 'best_time', 'announciator_id'];

    public function Announciator()
    {
        return $this->belongsTo(Announciator::class, 'announciator_id');
    }
}
