<?php

namespace App\Models;

use App\Traits\RecordsActivity;
use App\Traits\StringMarkerTrait;
use Carbon\Carbon;
use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Models\Competition
 *
 */
class Competition extends Model
{
    use FormAccessible;
    use StringMarkerTrait;
    use RecordsActivity;
    use TransformableTrait;
    use SoftDeletes;
    protected $fillable       = ['organizer_id', 'start_date', 'timetable_1', 'submit_date', 'header', 'info', 'season', 'classes', 'award', 'register', 'only_list', 'ignore_ageclasses', 'ignore_disciplines'];
    protected $with =['uploads'];
    protected $softDelete = true;

    public function __construct(array $attributes = [])
    {
        setlocale(LC_TIME, 'de_DE.utf8');
        parent::__construct($attributes);
    }

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
       return $this->belongsToMany(Ageclass::class)->orderBy('ageclasses.shortname');
    }

    /**
     * @return BelongsToMany
     */
    public function Disciplines()
    {
        return $this->belongsToMany(Discipline::class);
    }


    public function save(array $options = [])
    {
        parent::save();
    }

    public function reduceClasses()
    {
        return $this->trimClasses($this->ageclasses);
    }

    /**
     * Get the user's first name.
     *
     * @param  string $value
     * @return string
     */
    public function getGermanDate($value)
    {
        return $this->createViewFormat($value);
    }

    /**
     * Get attribute from date format
     * @param $input
     *
     * @return string
     */
    public function getStartDateAttribute($input)
    {
        return $this->createViewFormat($input);
    }

    /**
     * Get attribute from date format
     * @param $input
     */
    public function setStartDateAttribute($input)
    {
        $this->attributes['start_date'] = $this->createMysqlFormat($input);
    }

    /**
     * Get attribute from date format
     * @param $input
     *
     * @return string
     */
    public function getSubmitDateAttribute($input)
    {
        return $this->createViewFormat($input);
    }

    /**
     * Get attribute from date format
     * @param $input
     *
     * @return string
     */
    public function setSubmitDateAttribute($input)
    {
        $this->attributes['submit_date'] = $this->createMysqlFormat($input);
    }

    /**
     * @param $input
     * @return null|string
     */
    protected function createViewFormat($input)
    {
        if ($input != null) {
            return Carbon::parse($input)->format('d.m.Y');
        } else {
            return null;
        }
    }
    /**
     * @param $input
     * @return null|string
     */
    protected function createMysqlFormat($input)
    {
        if (!empty($input)) {
            $date = Carbon::parse($input)->format('d.m.Y');
            return Carbon::createFromFormat(config('app.date_locale_format'), $date)->format('Y-m-d');
        } else {
            return null;
        }
    }


    public function getAgeclassListAttribute()
    {
        return $this->ageclasses->pluck('shortname', 'id')->toArray();
    }
}
