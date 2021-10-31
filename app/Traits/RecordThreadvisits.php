<?php

namespace App\Traits;

use Illuminate\Support\Facades\Redis;

trait RecordThreadvisits
{
    public function recordVisit()
    {
        Redis::incr($this->visitsThreadCacheKey());

        return $this;
    }

    public function visits()
    {
        // return Redis::get($this->visitsThreadCacheKey()) ?? 0;
        return 0;
    }

    public function resetVisits()
    {
        Redis::del($this->visitsThreadCacheKey());

        return $this;
    }

    protected function visitsThreadCacheKey()
    {
        return "threads.{$this->id}.visits";
    }
}
