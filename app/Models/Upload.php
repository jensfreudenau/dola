<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Upload
 *
 * @property int $id
 * @property int $competition_id
 * @property string $filename
 * @property string $type
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property-read \App\Models\Competition $competition
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Upload whereCompetitionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Upload whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Upload whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Upload whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Upload whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Upload whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Upload whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Upload whereUpdatedBy($value)
 */
class Upload extends Model
{
    protected $fillable = ['competition_id', 'filename', 'type'];


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

    public function competition()
    {
        return $this->belongsTo(Competition::class, 'competition_id');
    }
}
