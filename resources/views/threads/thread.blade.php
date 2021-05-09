<div class="md:flex mb-3 md:hover:bg-gray-50 md:dark:hover:bg-gray-700 card hover:bg-gray-50 dark:hover:bg-gray-700 border-2 border-gray-100 dark:border-gray-800 p-7 rounded-3xl justify-between items-start">
    <div class="flex justify-between items-center mb-5">
        <a href="{{route('profile', $thread->creator->name)}}" class="md:mr-5 flex items-center">
            <img class="flex-shrink-0 order-first rounded-xl" width="64px" height="64px" src="https://gravatar.com/avatar/{{md5($thread->creator->email)}}?s=128" alt="{{$thread->creator->name}}'s avatar">
            <span class="md:hidden text-gray-400 ml-3 font-bold">{{$thread->creator->name}}</span>
        </a>
        <div class="block md:hidden">
            <div class="flex text-xs md:text-sm items-center">
                <div class="flex bg-gray-200 text-gray-500 rounded-full px-3 py-1 items-center">
                    <svg class="w-3 h-4 mb-1 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15 10" fill="currentColor">
                        <path d="M7.5 0C3.344 0 0 2.818 0 6.286c0 1.987 1.094 3.757 2.781 4.914l.117 2.35c.022.438.338.58.704.32l2.023-1.442c.594.144 1.219.18 1.875.18 4.156 0 7.5-2.817 7.5-6.285C15 2.854 11.656 0 7.5 0z"></path>
                    </svg>
                    {{$thread->replies_count}}
                </div>
                <div class="flex-auto cursor-pointer bg-indigo-500 text-white rounded-full px-3 py-1 ml-3">
                    {{Str::limit($thread->channel->name, 8,'')}}
                </div>
            </div>
        </div>
    </div>

    <div class="flex-1 flex-nowrap">
        <div class="flex justify-between mb-3">
            <div class="flex-1 mr-5"> {{-- flex-1 require otherwise it will cause overflow to other flex member --}}
                <a class="hover:underline text-lg font-semibold" href="{{$thread->path()}}">
                    @if (auth()->check() && $thread->updatedSince())
                        <span class="text-blue-700 dark:text-blue-400">
                            {{Str::limit($thread->title, 200,'...')}}
                        </span>
                    @else
                        <span class="text-black dark:text-white">{{Str::limit($thread->title, 200,'...')}}</span>
                    @endif
                </a>
            </div>
            <div class="hidden md:block">
                <div class="flex items-center">
                    <div class="flex text-black text-opacity-60 dark:text-white dark:text-opacity-50 rounded-full px-2">
                        <svg class="w-4 h-5 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15 10" fill="currentColor">
                            <path d="M7.5 0C3.344 0 0 2.818 0 6.286c0 1.987 1.094 3.757 2.781 4.914l.117 2.35c.022.438.338.58.704.32l2.023-1.442c.594.144 1.219.18 1.875.18 4.156 0 7.5-2.817 7.5-6.285C15 2.854 11.656 0 7.5 0z"></path>
                        </svg>
                        {{$thread->replies_count}}
                    </div>
                    <div class="flex text-black text-opacity-60 dark:text-white dark:text-opacity-50 rounded-full px-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 15" fill="currentColor">
                          <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                          <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                        </svg>
                        {{$thread->visits()}}
                    </div>
                    <div class="flex-auto text-center cursor-pointer bg-indigo-500 rounded-full px-3 py-1 text-sm ml-3">
                        <a class="text-white hover:underline" href="/threads/{{$thread->channel->slug}}">
                            {{Str::limit($thread->channel->name, 8,'')}}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <p class="mb-3 text-sm">
            {{Str::limit($thread->body, 220,'...')}}
        </p>

        @can('delete', $thread)
            <form action="{{$thread->path()}}" method="POST">
                @csrf
                @method('DELETE')

                <button aria-label="Delete Button" class="border-2 bg-red-500 border-red-600 rounded-full inline-block px-4">
                    <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </form>
        @endcan
    </div>
</div>