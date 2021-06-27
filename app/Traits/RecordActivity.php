<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait RecordActivity
{
    protected static function bootRecordActivity()
    {
        // if (auth()->guest()) {
        //     return;
        // } this cause the errors in test i can't figure out the reason

        foreach (static::getActivityEvents() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }
        static::deleting(function ($model) {
            $model->activities()->delete();
        });
    }

    protected static function getActivityEvents()
    {
        return ['created'];
    }

    protected function recordActivity($event)
    {
        if (Auth::guest()) {
            return;
        }

        $this->activities()->create([
            'type' => $this->getActivityType($event),
            'user_id' => auth_id(),
        ]);
    }

    protected function getActivityType($event)
    {
        return $event . '_' . strtolower((new \ReflectionClass($this))->getShortName());
    }
}
