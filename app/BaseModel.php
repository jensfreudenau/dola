<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 27.10.17
 * Time: 14:44
 */
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class BaseModel extends Model{

    public static function boot()
    {
        parent::boot();
        static::creating(function($model)
        {
            $user = Auth::user();
            $model->created_by = $user->id;
            $model->updated_by = $user->id;
        });
        static::updating(function($model)
        {
            $user = Auth::user();
            $model->updated_by = $user->id;
        });
    }

}