<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateThreadRequest;
use Illuminate\Support\Str;
use App\Models\Channel;
use App\Models\Thread;
use App\Filters\ThreadFilter;
use App\Http\Requests\UpdateThreadRequest;
use App\TrendingThreads;

class ThreadsController extends Controller
{
    public function __construct()
    {
        $this->middleware('honeypot')->only('store');
        $this->middleware(['auth', 'verified'])->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Channel $channel, ThreadFilter $filters, TrendingThreads $trending)
    {
        $threads = $this->getThreads($channel, $filters);

        if (request()->wantsJson()) {
            return $threads;
        }

        return view('threads.index', [
            'threads' => $threads,
            'trendings' =>$trending->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ThreadRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateThreadRequest $request)
    {
        $validated = $request->only(['_token', 'title', 'body', 'channel_id']);
        $validated['slug'] = Str::slug($request->title).'_'.uniqid();

        $thread = auth_user()->threads()->create($validated);

        return redirect($thread->path())
                ->with('flash', 'Your Thread has been published!');
    }

    /**
     * Display the specified resource.
     *
     * @param  String $channelSlug
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show($channelSlug, Thread $thread, TrendingThreads $trending)
    {
        if (auth()->check()) {
            auth_user()->read($thread);
        }

        $trending->set($thread);

        $thread->recordVisit();

        return view('threads.show', compact('thread'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ThreadRequest  $request
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update($channelSlug , UpdateThreadRequest $request, Thread $thread)
    {
        $this->authorize('update', $thread);
        
        $thread->update($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy($channelSlug, Thread $thread)
    {
        $this->authorize('delete', $thread);

        $thread->delete();

        return back()->with('flash', 'Your Thread has been Deleted');
    }

    public function getThreads($channel, $filters)
    {
        $threads = Thread::latest()->filter($filters);

        if ($channel->exists) {
            $threads->where('channel_id', $channel->id);
        }

        return $threads->paginate(10);
    }
}
