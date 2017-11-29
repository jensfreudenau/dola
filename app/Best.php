<?php

namespace App;

class Best extends BaseModel
{
    protected $fillable       = ['id', 'sex', 'filename', 'year'];
    public static function boot()
    {
        parent::boot();
    }
}
