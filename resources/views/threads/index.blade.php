@extends('layouts.app')

@section('content')
<div class="w-full lg:w-4/5 mx-auto">
    <div class="md:flex mt-10">
        <div class="inline-block md:hidden">
            <!--
              for Mobile layout.
            -->
            <v-dropdown>
              <template #button>
                <button type="button" class="flex nav-link">
                  Channels hi
                  <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                  </svg>
                </button>
              </template>
              <template #menu>
                <div class="p-1 max-h-80 overflow-y-auto">
                    <a href="/threads" class="dropdown-link">hi hello</a>
                    <a href="/threads" class="dropdown-link">hi hello</a>
                </div>
              </template>
            </v-dropdown>
        </div>
        <div class="hidden md:block h-full flex-none bg-gray-800 mr-10 rounded-3xl p-5">
            <a class="block text-white hover:text-gray-800 cursor-pointer hover:bg-gray-300 rounded-lg px-3 py-2 text-sm" href="/threads">All Threads</a>
    
            <a class="block text-white cursor-pointer hover:text-gray-800 hover:bg-gray-300 rounded-lg px-3 py-2 text-sm" href="/threads?popular=1">Popular Threads</a>

            <a class="block text-white cursor-pointer hover:text-gray-800 hover:bg-gray-300 rounded-lg px-3 py-2 text-sm" href="/threads?unanswered=1">Unanswered Threads</a>
        </div>
        <div class="flex-1">
            @forelse ($threads as $thread)
                @include('threads.thread')
            @empty
                No threads yet!
            @endforelse
        </div>
    </div>
</div>
@endsection
