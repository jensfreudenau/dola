<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ageclass whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ageclass whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ageclass whereDlv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ageclass whereFormat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ageclass whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ageclass whereLadv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ageclass whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ageclass whereRieping($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ageclass whereShortname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ageclass whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ageclass whereUpdatedBy($value)
 */
class Ageclass extends BaseModel
{
    /**
     * @return BelongsToMany
     */
    public function competitions()
    {
        return $this->belongsToMany(Competition::class);
    }
}
