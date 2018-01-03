<?php
namespace App\Models;

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
