<?php

namespace App\Models;

use App\Traits\StringMarkerTrait;
use Carbon\Carbon;
use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;


/**
 * App\Models\Competition
 *
 */
class Competition extends BaseModel
{
    use FormAccessible;
    use StringMarkerTrait;
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
    public function Ageclasses()
    {
       return $this->belongsToMany(Ageclass::class);
    }

    /**
     * @return BelongsToMany
     */
    public function Disciplines()
    {
        return $this->belongsToMany(Discipline::class);
    }

    public function getAgeclassListAttribute()
    {
        return $this->ageclasses->pluck('shortname', 'id')->toArray();
    }


    public function save(array $options = [])
    {
        if($this->timetable_1){
            $this->timetable_1 = $this->replaceTableTag($this->timetable_1, $this->tableStyle, $this->tableHeadStyle);
        }
        if($this->classes){
            $this->classes = $this->prepareClasses($this->classes);
        }
        parent::save();
    }

    public function reduceClasses()
    {
        return $this->trimClasses($this->classes);
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
