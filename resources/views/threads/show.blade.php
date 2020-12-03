@extends('layouts.app')

@section('content')
    <div class="bg-gray-800 w-3/4 h-auto mx-auto mt-30 p-7 rounded-3xl mt-14 text-white shadow-lg">
        <a href="/threads" class="flex text-gray-300 hover:text-white w-max">
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-5-5 5-5" />
            </svg>
            Go Back
        </a>
        <div class="py-3 rounded-3xl">
            <h3 class="text-xl mb-3">{{ $thread->title }}</h3>
            <p>
                {{$thread->body}}
            </p>
        </div>
        <hr>
        <div>
            <h2 class="text-2xl mb-3">Replies</h2>
            @foreach ($thread->replies as $reply)
                <div class="bg-gray-700 p-3 mb-3 rounded-xl text-white">
                    <h3>
                        <a class="text-blue-300" href="#">{{$reply->owner->name}}</a> said {{$reply->created_at->diffForHumans()}}
                    </h3>
                    <p>{{$reply->body}}</p>
                </div>
            @endforeach
        </div>
    </div>
@endsection
