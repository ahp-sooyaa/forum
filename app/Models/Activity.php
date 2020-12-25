<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = ['subject'];

    public function subject()
    {
        return $this->morphTo();
    }

    protected static function feed($user)
    {
        return $user->activities()->latest()->take(30)->get()->groupBy(function ($activity) {
            return $activity->created_at->format('Y-M-d');
        });
    }
}
