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
            <div class="flex flex-row-reverse justify-between">
                <div>
                    <a href="#">{{$thread->creator->name}}</a> posted at {{$thread->created_at->diffForHumans()}}
                </div>
                <h3 class="text-xl mb-3">
                     {{ $thread->title }}
                </h3>
            </div>
            <p>
                {{$thread->body}}
            </p>
        </div>
        <hr class="border-gray-600 my-3">
        <div class="mb-5">
            @include('threads.replies')
        </div>

        <div>
            @auth
                <form action="{{ $thread->path(). '/replies' }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <div class="mt-1 relative rounded-md shadow-sm">
                          <textarea name="body" rows="10" class="text-area"></textarea>
                        </div>
                    </div>
                    <button class="btn-blue">
                        Post
                    </button>
                </form>
            @else
                <div class="text-center">
                    Please <a href="{{route('login')}}">Login</a> to participate in forum discussion!
                </div>
            @endauth
        </div>
    </div>
@endsection
