<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Best
 *
 * @property int $id
 * @property int $year
 * @property string $sex
 * @property int $created_by
 * @property int $updated_by
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string $filename
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Best whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Best whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Best whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Best whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Best whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Best whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Best whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Best whereYear($value)
 */
class Best extends Model
{
    protected $fillable       = ['id', 'sex', 'filename', 'year'];
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
