<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Ageclass
 *
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property mixed $competitions
 * @property string $name
 * @property string $shortname
 * @property string $ladv
 * @property string $dlv
 * @property string $format
 * @property int $created_by
 * @property int $updated_by
 * @property string $rieping

 */
class Ageclass extends Model
{
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
    /**
     * @return BelongsToMany
     */
    public function competitions()
    {
        return $this->belongsToMany(Competition::class);
    }
}
