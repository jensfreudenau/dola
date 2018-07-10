<?php

namespace App\Models;

use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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

 */
class Address extends Model
{
    use RecordsActivity;
    protected $fillable = ['name', 'telephone', 'fax', 'email', 'street', 'zip', 'city'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $user              = Auth::user();
            $model->created_by = $user->id;
            $model->updated_by = $user->id;
        });
        static::updating(function ($model) {
            $user              = Auth::user();
            $model->updated_by = $user->id;
        });
    }

    public function organizers()
    {
        return $this->hasMany(Organizer::class);
    }

}
