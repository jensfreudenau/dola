<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Discipline
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discipline whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discipline whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discipline whereDlv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discipline whereFormat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discipline whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discipline whereLadv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discipline whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discipline whereRieping($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discipline whereShortname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discipline whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discipline whereUpdatedBy($value)
 */
class Discipline extends BaseModel
{
    /**
     * @return BelongsToMany
     */
    public function competitions()
    {
        return $this->belongsToMany(Competition::class);
    }
}
