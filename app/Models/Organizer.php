<?php
namespace App\Models;

use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Game;
use Illuminate\Support\Facades\Auth;

/**
 * Class Team
 *
 * @package App
 * @property string $name
*/
class Organizer extends Model
{
    use SoftDeletes;
    use RecordsActivity;

    protected $fillable = ['name', 'address_id', 'leader', 'homepage'];

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

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function competition()
    {
        return $this->hasMany(Competition::class);
    }

}
