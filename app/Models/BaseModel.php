<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 27.10.17
 * Time: 14:44
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Support\Facades\Log;
/**
 * App\Models\BaseModel
 *
 */
abstract class BaseModel extends Model implements Transformable
{
    use TransformableTrait;
    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $user              = Auth::user();
            $model->created_by = $user->id;
            $model->updated_by = $user->id;
        });
        static::updating(function ($model) {
            $user              = Auth::user();
            $model->updated_by = $user->id;
        });
    }
}