@extends('layouts.app')

@section('content')

    <div class="bg-gray-800 w-3/4 h-auto mx-auto mt-30 p-7 rounded-3xl mt-14 text-gray-300 shadow-lg">
        <h2 class="mb-3 text-3xl">Forum Threads</h2>
        @foreach ($threads as $thread)
            <div class="py-3 @if(!$loop->last) mb-3 @endif rounded-3xl">
                <h3 class="hover:text-white">
                    <a href="{{$thread->path()}}">{{$thread->title}}</a>
                </h3>
                <p>
                    {{$thread->body}}
                </p>
            </div>
            @if (!$loop->last)
                <hr>
            @endif
        @endforeach
    </div>

@endsection
