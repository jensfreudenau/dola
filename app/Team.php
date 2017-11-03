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
class Team extends BaseModel
{
    use SoftDeletes;

    protected $fillable = ['name', 'addresses_id', 'leader', 'homepage'];

    public static function boot()
    {
        parent::boot();
    }

    public function players()
    {
        return $this->hasMany(Player::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function competition()
    {
        return $this->hasMany(Competition::class);
    }

    public function getGamesAttribute()
    {
        return Game::where(function($query) {
            $query->where('team1_id', $this->attributes['id'])->orWhere('team2_id', $this->attributes['id']);
        })
        ->whereNotNull('result1')
        ->count();
    }

    public function getWonAttribute()
    {
        return Game::whereNotNull('result1')
            ->where(function($query) {
                $query->where(function($query2) {
                    $query2->where('team1_id', $this->attributes['id'])->whereRaw('result1 > result2');
                })->orWhere(function($query2) {
                    $query2->where('team2_id', $this->attributes['id'])->whereRaw('result1 < result2');
                });
            })
            ->count();
    }

    public function getTiedAttribute()
    {
        return Game::whereNotNull('result1')
            ->whereRaw('result1 = result2')
            ->where(function($query) {
                $query->where('team1_id', $this->attributes['id'])
                    ->orWhere('team2_id', $this->attributes['id']);
            })
            ->count();
    }

    public function getLostAttribute()
    {
        return Game::whereNotNull('result1')
            ->where(function($query) {
                $query->where(function($query2) {
                    $query2->where('team1_id', $this->attributes['id'])->whereRaw('result1 < result2');
                })->orWhere(function($query2) {
                    $query2->where('team2_id', $this->attributes['id'])->whereRaw('result1 > result2');
                });
            })
            ->count();
    }

    public function getPointsAttribute()
    {
        return $this->getWonAttribute() * 3 + $this->getTiedAttribute() * 1;
    }

}
