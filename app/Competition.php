<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Support\Facades\Log;

class Competition extends Model
{
    use FormAccessible;
    protected $fillable = ['addresses_id', 'team_id', 'start_date', 'reuslts_1', 'reuslts_2', 'timetable_1', 'timetable_2', 'participators_1', 'participators_2', 'submit_date', 'header', 'info', 'season', 'classes', 'award'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }
//    public function address()
//    {
//        return $this->belongsTo(Address::class, 'addresses_id');
//    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function ParticipatorTeam()
    {
        return $this->hasMany(ParticipatorTeam::class);
    }

    public function posts()
    {
        return $this->hasManyThrough( Participator::class,ParticipatorTeam::class);
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

    /**
     * Get attribute from date format
     * @param $input
     *
     * @return string
     */
    public function getStartDateAttribute($input)
    {
        if ($input != null) {
            $customFormat =  Carbon::parse($input)->format('d.m.Y') ;
        } else {
            $customFormat = '';
        }

        return $customFormat;
    }
    /**
     * Get attribute from date format
     * @param $input
     *
     * @return string
     */
    public function setStartDateAttribute($input)
    {
        if ($input != null && $input != '') {
            $this->attributes['start_time'] = Carbon::createFromFormat(config('app.date_format'), $input)->format('Y-m-d');
        } else {
            $this->attributes['start_time'] = null;
        }
    }
    /**
     * Get attribute from date format
     * @param $input
     *
     * @return string
     */
    public function getSubmitDateAttribute($input)
    {
        if ($input != null) {
            $customFormat =  Carbon::parse($input)->format('d.m.Y') ;
        } else {
            $customFormat = '';
        }

        return $customFormat;
    }
    /**
     * Get attribute from date format
     * @param $input
     *
     * @return string
     */
    public function setSubmitDateAttribute($input)
    {
        if ($input != null && $input != '') {
            $this->attributes['submit_time'] = Carbon::createFromFormat(config('app.date_format'), $input)->format('Y-m-d');
        } else {
            $this->attributes['submit_time'] = null;
        }
    }
}
