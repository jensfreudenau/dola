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

 */
class Discipline extends BaseModel
{
    /**
     * @return BelongsToMany
     */
    public function competitions()
    {
        return $this->belongsToMany(Competition::class)->orderBy('disciplines.shortname');
    }
}
