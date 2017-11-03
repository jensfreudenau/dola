<?php
namespace App;

/**
 * Class Role
 *
 * @package App
 * @property string $title
*/
class Role extends BaseModel
{
    protected $fillable = ['title'];

    public static function boot()
    {
        parent::boot();
    }
}
