@extends('layouts.app')

@section('content')
<div class="w-full lg:w-5/6 mx-auto px-6">
    <div class="md:flex mt-10 items-start">
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

        <div class="flex-1 mr-5">
            @forelse ($threads as $thread)
                @include('threads.thread')
            @empty
                No threads yet!
            @endforelse
            {{ $threads->links() }}
        </div>

        <div>
          <div class="h-full hidden lg:block lg:w-70 mb-5 ml-5 rounded-3xl text-black w-60">
            <form action="/threads/search" method="GET">
              <input type="text" placeholder="Search Something ...." class="border-0 focus:ring-accent text-input w-full" name="q">
              <button class="btn-accent text-xs mt-4">Search</button>
            </form>
          </div>

          @if (count($trendings))
              <div class="h-full hidden lg:block lg:w-70 ml-5 rounded-3xl w-60">
                <h2 class="dark:text-white font-semibold mb-5 text-black tracking-wider">Trending Threads</h2>
                <div class="space-y-3">
                  @foreach ($trendings as $trending)
                      <div class="flex text-sm leading-normal">
                        <div class="flex-shrink-0 rounded-full bg-white shadow w-6 h-6 mr-4 text-center">
                          <span class="align-middle">{{$loop->index + 1}}</span>
                        </div>
                        <a href="{{$trending->path}}" class="text-black dark:text-white hover:underline block">{{$trending->title}}</a>
                      </div>
                  @endforeach
                </div>
              </div>
          @endif
        </div>
    </div>
</div>
@endsection
