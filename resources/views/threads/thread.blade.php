<div class="mb-3 bg-gray-800 p-7 rounded-3xl text-gray-300 shadow-md">
    <div class="flex justify-between mb-3">
        <a class="hover:text-gray-300 font-semibold text-xl text-white" href="{{$thread->path()}}">
            {{$thread->title}}
        </a>
        <div class="flex items-center">
            <div class="flex border-2 border-gray-700 bg-gray-600 rounded-full px-3">
                <svg class="w-4 h-5 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15 10" fill="currentColor">
                    <path d="M7.5 0C3.344 0 0 2.818 0 6.286c0 1.987 1.094 3.757 2.781 4.914l.117 2.35c.022.438.338.58.704.32l2.023-1.442c.594.144 1.219.18 1.875.18 4.156 0 7.5-2.817 7.5-6.285C15 2.854 11.656 0 7.5 0z"></path>
                </svg>
                {{$thread->replies_count}}
            </div>
            <div class="block cursor-pointer border-2 border-indigo-600 bg-indigo-500 text-white rounded-full px-3 py-1 text-sm ml-3">
                {{Str::limit($thread->channel->name, 10,'')}}
            </div>
        </div>
    </div>
    <p class="mb-3">
        {{$thread->body}}
    </p>
    @can('delete', $thread)
        <form action="{{$thread->path()}}" method="POST">
            @csrf
            @method('DELETE')

            <button class="border-2 bg-red-500 border-red-600 rounded-full inline-block px-4">
                <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </button>
        </form>
    @endcan
</div>