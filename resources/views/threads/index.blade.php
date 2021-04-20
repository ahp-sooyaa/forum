@extends('layouts.app')

@section('content')
<div class="w-full lg:w-5/6 mx-auto px-6">
    <div class="md:flex mt-10">
        <div class="md:hidden mb-3">
            <!--
              for Mobile layout.
            -->
            <a href="/threads/create" class="fixed bottom-7 right-7 btn-indigo text-sm rounded-full w-16 h-16">
                <svg class="my-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
            </a>
        </div>

        <div class="flex-1">
            @forelse ($threads as $thread)
                @include('threads.thread')
            @empty
                No threads yet!
            @endforelse
            {{ $threads->links() }}
        </div>

        @if (count($trendings))
            <div class="hidden flex-none w-60 lg:w-70 lg:block bg-gray-700 border-2 border-gray-800 py-7 px-3 rounded-3xl text-white h-full ml-3">
              <h2 class="font-semibold tracking-wider mb-3 text-center">Trending Threads</h2>
              <div class="space-y-2">
                @foreach ($trendings as $trending)
                    <div class="flex text-sm">
                      <div class="flex-none rounded-full border-2 bg-indigo-600 text-white border-indigo-600 w-6 h-6 mr-2 text-center">
                        {{$loop->index + 1}}
                      </div>
                      <a href="{{$trending->path}}" class="text-white hover:underline block">{{$trending->title}}</a>
                    </div>
                @endforeach
              </div>
            </div>
        @endif
    </div>
</div>
@endsection
