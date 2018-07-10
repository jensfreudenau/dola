<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 02.07.18
 * Time: 13:01
 */

namespace App\Traits;

trait RecordsActivity
{
    protected static function bootRecordsActivity()
    {
        if (auth()->guest()) return;

        foreach (static::getActivitiesToRecord() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }

        static::deleting(function ($model) {
            $model->activity()->delete();
        });
    }

    /**
     * Fetch all model events that require activity recording.
     *
     * @return array
     */
    protected static function getActivitiesToRecord()
    {
        return ['created', 'updated', 'deleted'];
    }

    protected function recordActivity($event)
    {
        $this->activity()->create(
            [
                'user_id' => auth()->id(),
                'type' => $event,
                'component' => $this->getActivityComponent(),
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]
        );
    }

    public function activity()
    {
        return $this->morphMany('App\Models\Activity', 'subject');
    }

    protected function getActivityComponent()
    {
        return strtolower((new \ReflectionClass($this))->getShortName());
    }

}