<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Support\Facades\Log;

/**
 * @property string $submit_date
 * @property mixed $organizer
 * @property mixed $uploads
 * @property mixed $announciator
 * @property mixed $participators
 * @property string $start_date
 */
class Competition extends BaseModel
{
    use FormAccessible;
    protected $fillable       = ['organizer_id', 'start_date', 'timetable_1', 'submit_date', 'header', 'info', 'season', 'classes', 'award', 'register'];
    protected $tableStyle     = '<table class="table table-sm table-hover table-responsive">';
    protected $tableHeadStyle = '<thead class="thead-inverse">';

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
    public function organizer()
    {
        return $this->belongsTo(Organizer::class, 'organizer_id');
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
    public function Announciator()
    {
        return $this->hasMany(Announciator::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function Participators()
    {
        return $this->hasManyThrough(Participator::class, Announciator::class);
    }

    public function save(array $options = [])
    {
        $this->replaceTableTag();
        $this->trimClasses();
        parent::save();
    }

    protected function trimClasses()
    {
        $this->classes = str_replace(',', '|', $this->classes);
        $this->classes = str_replace(' ', '', $this->classes);
        $this->classes = str_replace('|', ', ', $this->classes);
    }
    protected function replaceTableTag()
    {
        $this->timetable_1 = str_replace('Uhr', '', $this->timetable_1);
        $this->timetable_1 = str_replace('<table>', $this->tableStyle, $this->timetable_1);
        $this->timetable_1 = str_replace('<thead>', $this->tableHeadStyle, $this->timetable_1);
    }

    public function reduceClasses()
    {
        //WKU12, W10/W11, WJU14, W12/W13, WJU16, W14/W15, MKU12, M10/11, MJU14, M12/13, MJU16, M14/15,
        //WK U10, WK U12, WJ U14, WJ U16, WJ U18/U20, MK U10, MK U12, MJ U14, MJ U16, MJ U18/U20
        $sex    = ['WK', 'WJ', 'MK', 'MJ', 'W10/W11', 'W12/W13', 'W14/W15', 'M10/11', 'M12/13', 'M14/15'];
        $class  = str_replace($sex, '', $this->classes);
        $class  = str_replace(' ', '', $class);
        $class  = explode(',', $class);
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
        if ($input != null && $input != '') {
            $this->attributes['submit_date'] = Carbon::createFromFormat(config('app.date_format'), $input)->format('Y-m-d');
        } else {
            $this->attributes['submit_date'] = null;
        }
    }
}
