<?php

namespace App\Models;

/**
 * App\Models\Address
 *
 * @property \Carbon\Carbon $created_at
 * @property int $id
 * @property \Carbon\Carbon $updated_at
 * @property string $name
 * @property string $telephone
 * @property string $fax
 * @property string $street
 * @property string $zip
 * @property string $city
 * @property string $email
 * @property int $created_by
 * @property int $updated_by
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Organizer[] $organizers
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereFax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereTelephone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereZip($value)
 */
class Address extends BaseModel
{

    protected $fillable = ['name', 'telephone', 'fax', 'email', 'street', 'zip', 'city'];
    public function organizers()
    {
        return $this->hasMany(Organizer::class);
    }

    public static function boot()
    {
        parent::boot();
    }
}
