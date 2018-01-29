<?php

namespace App\Models;
use Collective\Html\Eloquent\FormAccessible;

/**
 * App\Models\Additional
 *
 * @property \Carbon\Carbon $created_at
 * @property int $id
 * @property \Carbon\Carbon $updated_at
 * @property int $competition_id
 * @property string $key
 * @property string $value
 * @property string $mnemonic
 * @property int $created_by
 * @property int $updated_by
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Additional whereCompetitionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Additional whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Additional whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Additional whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Additional whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Additional whereMnemonic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Additional whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Additional whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Additional whereValue($value)
 */
class Additional extends BaseModel
{
    use FormAccessible;
    protected $fillable = ['key', 'value', 'mnemonic', 'competition_id'];
}
