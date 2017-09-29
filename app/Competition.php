<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Collective\Html\Eloquent\FormAccessible;

class Competition extends Model
{
    use FormAccessible;
    protected $fillable = ['start_date', 'timetable_1', 'timetable_2', 'submit_date', 'header', 'addresses_id', 'team_id', 'season'];

    public function address()
    {
        return $this->belongsTo(Address::class, 'addresses_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    /**
     * Get the user's first name.
     *
     * @param  string $value
     * @return string
     */
    public function getGermanDate($value)
    {
        return Carbon::parse($value)->format('d.m.Y');
    }
}
