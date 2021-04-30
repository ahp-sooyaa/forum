<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\TrendingThreads;

class SearchController extends Controller
{
    public function show(TrendingThreads $trending)
    {
        if(request()->expectsJson())
        {
            return Thread::search(request('q'))->paginate(5);
        }

        return view('threads.search', [
            'trendings' =>$trending->get()
        ]);
    }
}
