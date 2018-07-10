<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = [];

    public static function feed($user)
    {
       return $user->activity()->latest()->with('subject')->get()->groupBy('component');
    }

    public function subject()
    {
        return $this->morphTo();
    }


}
