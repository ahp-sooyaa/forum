<?php

namespace App\Models;

use App\Traits\RecordActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Events\ThreadHasNewReply;
use App\Traits\RecordThreadVisits;
use Illuminate\Support\Str;

class Thread extends Model
{
    use HasFactory, RecordActivity, RecordThreadVisits;

    protected $guarded = [];

    protected $with = ['creator', 'channel'];

    protected $appends = ['isSubscribed'];

    protected $casts = [
        'locked' => 'boolean',
    ];

    // protected $withCount = ['replies'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($thread) {
            $thread->replies->each->delete();
        });
    }

    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->slug}";
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function activities()
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    public function addReply($reply)
    {
        $reply = $this->replies()->create($reply);

        event(new ThreadHasNewReply($reply));

        return $reply;
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    public function updatedSince($user = null)
    {
        $user = $user ?: auth_user();

        $key = $user->visitedThreadCacheKey($this);

        return $this->updated_at > cache($key);
    }

    public function getIsSubscribedAttribute()
    {
        return $this->subscriptions->contains('user_id', auth_id());
    }

    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ?: auth()->id()
        ]);

        return $this;
    }

    public function unsubscribe($userId = null)
    {
        $this->subscriptions()->where('user_id', $userId ?: auth()->id())->delete();
    }

    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    public function markBestReply($id)
    {
        $this->update(['best_reply_id' => $id]);
    }
}
