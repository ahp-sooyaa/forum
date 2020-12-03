<h2 class="text-2xl mb-3">Replies</h2>
@foreach ($thread->replies as $reply)
    <div class="bg-gray-700 p-3 mb-3 rounded-xl text-white">
        <h3>
            <a class="text-blue-300" href="#">{{$reply->owner->name}}</a> said {{$reply->created_at->diffForHumans()}}
        </h3>
        <p>{{$reply->body}}</p>
    </div>
@endforeach