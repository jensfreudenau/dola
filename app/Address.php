<?php

namespace App;

class Address extends BaseModel
{
    public function organizers()
    {
        return $this->hasMany(Organizer::class);
    }

    public static function boot()
    {
        parent::boot();
    }
}
