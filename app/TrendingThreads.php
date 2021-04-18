<?php

namespace App;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redis;

class TrendingThreads
{
    public function get()
    {
        return array_map('json_decode', Redis::zrevrange($this->cacheKey(), 0, 4));
    }

    public function set($thread)
    {
        Redis::zincrby($this->cacheKey(), 1, json_encode([
            'title' => $thread->title,
            'path' => $thread->path()
        ]));
    }

    public function cacheKey()
    {
        return App::environment('testing') ? 'testing_trending_threads' : 'trending_threads';
    }

    public function reset()
    {
        Redis::del($this->cacheKey());
    }
}