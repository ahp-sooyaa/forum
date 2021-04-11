<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReplyRequest;
use App\Http\Requests\UpdateReplyRequest;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Support\Facades\Gate;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(1);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $channelId
     * @param  \App\Http\Requests\ReplyRequest  $request
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function store($channelId, Thread $thread, CreateReplyRequest $request)
    {
        // if (Gate::denies('create', new Reply)) {
        //     return response('Posting frequently. take a break', 429);
        // }

        // try {
        $reply = $thread->addReply([
            'body' => $request->body,
            'user_id' => auth()->id()
        ]);
        // } catch (\Exception $e) {
        //     return response('Sorry, your reply could not be saved. Contained spam', 422);
        // }

        return $reply->load(['owner', 'thread'])->loadCount('favorites');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function show(Reply $reply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function edit(Reply $reply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReplyRequest $request, Reply $reply)
    {
        // try {
        $reply->update(['body' => $request->body]);
        // } catch (\Exception $e) {
        //     return response('Sorry you could not be updated', 422);
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('delete', $reply);

        $reply->delete();

        //You can use model boot method to track crud events & add logic to boot method
        // $reply->thread->decrement('replies_count');
    }
}
