<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Support\Facades\Log;

class Competition extends BaseModel
{
    use FormAccessible;
    protected $fillable = ['team_id', 'start_date', 'timetable_1',  'submit_date', 'header', 'info', 'season', 'classes', 'award', 'register'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public static function boot()
    {
        parent::boot();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Uploads()
    {
        return $this->hasMany(Upload::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ParticipatorTeam()
    {
        return $this->hasMany(ParticipatorTeam::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function Participators()
    {
        return $this->hasManyThrough(Participator::class, ParticipatorTeam::class);
    }

    public function save(array $options = [])
    {
        $this->replaceTableTag();
        parent::save();
    }

    public function reduceClasses() {

        //WK U10, WK U12, WJ U14, WJ U16, WJ U18/U20, MK U10, MK U12, MJ U14, MJ U16, MJ U18/U20
        $sex = ['WK', 'WJ', 'MK', 'MJ'];
        $class = str_replace($sex, '', $this->classes);
        $class = explode(',', $class);
        $result = array_unique($class);
        return implode(',', $result);
    }
    protected function replaceTableTag()
    {
        $this->timetable_1 = str_replace('Uhr', '', $this->timetable_1);
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
            $customFormat = Carbon::parse($input)->format('d.m.Y');
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
            $this->attributes['start_date'] = Carbon::createFromFormat(config('app.date_format'), $input)->format('Y-m-d');
        } else {
            $this->attributes['start_date'] = null;
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
            $customFormat = Carbon::parse($input)->format('d.m.Y');
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
            $this->attributes['submit_date'] = Carbon::createFromFormat(config('app.date_format'), $input)->format('Y-m-d');
        } else {
            $this->attributes['submit_date'] = null;
        }
    }
}
