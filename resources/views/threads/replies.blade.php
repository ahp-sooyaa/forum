<h2 class="text-2xl mb-3">
    Replies <span class="bg-gray-700 rounded-xl px-2 py-1 text-lg">{{ $thread->replies->count() }}</span>
</h2>
@if ($thread->replies->count() != 0)
    @foreach ($thread->replies as $reply)
        <div class="bg-gray-700 p-3 mb-3 rounded-xl text-white">
            <h3>
                <a href="#">{{$reply->owner->name}}</a> said {{$reply->created_at->diffForHumans()}}
            </h3>
            <p>{{$reply->body}}</p>
        </div>
    @endforeach
@else 
    No Replies yet!
@endif