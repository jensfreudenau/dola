<?php

namespace App;
use Collective\Html\Eloquent\FormAccessible;

/**
 * @property \Carbon\Carbon $created_at
 * @property int $id
 * @property \Carbon\Carbon $updated_at
 */
class Additional extends BaseModel
{
    use FormAccessible;
    protected $fillable = ['key', 'value', 'mnemonic', 'external_id'];
}
