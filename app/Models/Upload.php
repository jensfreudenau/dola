<?php

namespace App\Models;

class Upload extends BaseModel
{
    protected $fillable = ['competition_id', 'filename', 'type'];


    public static function boot()
    {
        parent::boot();
    }

    public function competition()
    {
        return $this->belongsTo(Competition::class, 'competition_id');
    }
}
