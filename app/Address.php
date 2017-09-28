<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public function teams()
    {
        return $this->hasMany(Team::class);
    }
}
