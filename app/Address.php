<?php

namespace App;

class Address extends BaseModel
{
    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    public static function boot()
    {
        parent::boot();
    }
}
