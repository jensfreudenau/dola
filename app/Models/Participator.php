<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Participator
 *
 * @property mixed $announciator
 * @property \Carbon\Carbon $created_at
 * @property int $id
 * @property \Carbon\Carbon $updated_at
 * @property int $announciator_id
 * @property string $prename
 * @property string $lastname
 * @property string $birthyear
 * @property string $ageclass_id
 * @property id $discipline_id
 * @property string $discipline_cross
 * @property string $best_time
 * @property-read \App\Models\Ageclass $Ageclass
 * @property-read \App\Models\Announciator $Announciator
 * @property-read \App\Models\Discipline $Discipline
 * @property-read string $full_name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Participator whereAgeclassId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Participator whereAnnounciatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Participator whereBestTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Participator whereBirthyear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Participator whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Participator whereDisciplineId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Participator whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Participator whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Participator wherePrename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Participator whereUpdatedAt($value)
 */
class Participator extends Model
{
    protected $fillable = ['prename', 'lastname', 'birthyear', 'clubname', 'ageclass_id', 'discipline_id','discipline_cross', 'best_time', 'announciator_id'];

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

    public function getDisciplineAttribute()
    {
        if($this->discipline_id == '') {
            return $this->discipline_cross;
        }
        else {
            return $this->Discipline()->value('shortname');
        }
    }
}
