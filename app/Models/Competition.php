<?php

namespace App\Models;

use Carbon\Carbon;
use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Traits\ParseDataTrait;
/**
 * @property string $submit_date
 * @property mixed $organizer
 * @property mixed $uploads
 * @property mixed $announciator
 * @property mixed $participators
 * @property string $start_date
 * @property mixed $ageclasses
 * @property mixed $disciplines
 */
class Competition extends BaseModel
{
    use FormAccessible;
    protected $fillable       = ['organizer_id', 'start_date', 'timetable_1', 'submit_date', 'header', 'info', 'season', 'classes', 'award', 'register', 'only_list'];
    protected $tableStyle     = '<table class="table table-sm table-hover table-responsive">';
    protected $tableHeadStyle = '<thead class="thead-inverse">';

    public function __construct(array $attributes = [])
    {
        setlocale(LC_TIME, 'de_DE.utf8');
        parent::__construct($attributes);
    }

    public static function boot()
    {
        parent::boot();
    }

    /**
     * @return BelongsTo
     */
    public function organizer()
    {
        return $this->belongsTo(Organizer::class, 'organizer_id');
    }

    /**
     * @return HasMany
     */
    public function Uploads()
    {
        return $this->hasMany(Upload::class);
    }

    /**
     * @return HasMany
     */
    public function Announciator()
    {
        return $this->hasMany(Announciator::class);
    }

    /**
     * @return HasManyThrough
     */
    public function Participators()
    {
        return $this->hasManyThrough(Participator::class, Announciator::class);
    }

    /**
     * @return BelongsToMany
     */
    public function ageclasses()
    {
       return $this->belongsToMany(Ageclass::class);
    }

    /**
     * @return BelongsToMany
     */
    public function disciplines()
    {
        return $this->belongsToMany(Discipline::class);
    }

    public function getAgeclassListAttribute()
    {
        return $this->ageclasses->pluck('shortname', 'id')->toArray();
    }

    use  ParseDataTrait;
    public function save(array $options = [])
    {
        if($this->timetable_1){
            $this->timetable_1 = $this->replaceTableTag($this->timetable_1, $this->tableStyle, $this->tableHeadStyle);
        }
        if($this->classes){
            $this->classes = $this->trimClasses($this->classes);
        }
        parent::save();
    }

    public function reduceClasses()
    {
        //WKU12, W10/W11, WJU14, W12/W13, WJU16, W14/W15, MKU12, M10/11, MJU14, M12/13, MJU16, M14/15,
        //WK U10, WK U12, WJ U14, WJ U16, WJ U18/U20, MK U10, MK U12, MJ U14, MJ U16, MJ U18/U20
        $sex   = ['WK', 'WJ', 'MK', 'MJ', 'W10/W11', 'W12/W13', 'W14/W15', 'M10/11', 'M12/13', 'M14/15'];
        $class = str_replace($sex, '', $this->classes);
        $class = str_replace(' ', '', $class);
        $class = explode(',', $class);
        $class = array_unique($class);
        return implode(', ', $class);
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
        if (!empty($input)) {
            $this->attributes['submit_date'] = Carbon::createFromFormat(config('app.date_format'), $input)->format('Y-m-d');
        } else {
            $this->attributes['submit_date'] = null;
        }
    }
}
