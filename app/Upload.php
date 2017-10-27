<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    protected $fillable = ['competition_id', 'filename', 'type'];

    public function competition()
    {
        return $this->belongsTo(Competition::class, 'competition_id');
    }
}
