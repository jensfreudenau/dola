<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Announciator
 *
 * @property mixed $participator
 * @property mixed $competition
 * @property int $id
 * @property int|null $competition_id
 * @property string $name
 * @property string|null $clubname
 * @property string|null $street
 * @property string|null $city
 * @property string $email
 * @property string|null $telephone
 * @property int|null $resultlist
 * @property string|null $create_date
 * @property \Carbon\Carbon|null $created_at
 * @property string|null $modified_by
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\Competition|null $Competition
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Participator[] $Participator
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Announciator whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Announciator whereClubname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Announciator whereCompetitionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Announciator whereCreateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Announciator whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Announciator whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Announciator whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Announciator whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Announciator whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Announciator whereResultlist($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Announciator whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Announciator whereTelephone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Announciator whereUpdatedAt($value)
 */
class Announciator extends Model
{
    protected $fillable = ['competition_id', 'name', 'street', 'city', 'email', 'telephone', 'resultlist'];

    public static function boot()
    {
        parent::boot();
    }

    public function Competition()
    {
        return $this->belongsTo(Competition::class, 'competition_id');
    }

    public function Participator()
    {
        return $this->hasMany(Participator::class);
    }
}
