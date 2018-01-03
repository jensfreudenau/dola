<?php

namespace App\Models;

/**
 * @property \Carbon\Carbon $created_at
 * @property int $id
 * @property \Carbon\Carbon $updated_at
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
