<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Game;

/**
 * Class Team
 *
 * @package App
 * @property string $name
*/
class Organizer extends BaseModel
{
    use SoftDeletes;

    protected $fillable = ['name', 'address_id', 'leader', 'homepage'];

    public static function boot()
    {
        parent::boot();
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function competition()
    {
        return $this->hasMany(Competition::class);
    }

}
