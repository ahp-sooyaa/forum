<?php

namespace App\Models;

use App\Traits\RecordActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory, RecordActivity;

    protected $guarded = [];

    protected $with = ['owner', 'favorites', 'thread'];

    protected $withCount = ['favorites'];

    protected $appends = ['isFavorited'];

    protected static function boot()
    {
        parent::boot();

        /**
         * you can write this in the favorite model
         * bcuz favorite & reply are morph relationship.
         * instead of hard code $reply you can write $model in favorite model
        */
        static::deleting(function ($reply) {
            $reply->favorites->each->delete();
            $reply->thread->decrement('replies_count');
        });

        static::created(function ($reply) {
            $reply->thread->increment('replies_count');
        });
    }

    public function path()
    {
        return $this->thread->path() . "#reply-{$this->id}";
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function activities()
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    public function thread()
    {
        return $this->belongsto(Thread::class);
    }

    public function isFavorited()
    {
        return $this->favorites->contains('user_id', auth_id());
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }

    public function favorite()
    {
        $this->favorites()->create([
            'user_id' => auth()->id()
        ]);
    }

    public function unFavorite()
    {
        $this->favorites()->where(['user_id' => auth_id()])->get()->each->delete();
    }

    // public function isOp($thread)
    // {
    //     return $this->owner->name == $thread->creator->name;
    // }
}
