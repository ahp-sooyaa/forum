@extends('layouts.app')

@section('content')
    <v-thread-show :initial-replies-count="{{$thread->replies_count}}" inline-template>
        <div class="w-full lg:w-3/5 mx-auto md:px-6">
            {{-- <div class="flex items-center justify-between"> --}}
                <a class="flex items-center text-gray-300 hover:text-gray-400" href="/threads">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    Back
                </a>
                <button @click="reply" class="fixed bottom-7 right-7 btn-indigo text-sm rounded-full w-16 h-16">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </button>
            {{-- </div> --}}
            <div class="flex mt-7 justify-start items-end">
                <div class="w-8 h-8 ml-5 mr-3 border-t-4 border-l-4 border-gray-300 block align-bottom"></div>
                <div class="flex items-center justify-between w-full bg-gray-800 px-6 py-4 rounded-2xl text-gray-300 shadow-md">
                    <div class="text-sm">
                        <a href="{{$thread->creator->path()}}">{{ucfirst($thread->creator->name)}}</a> started this conversation {{$thread->created_at->diffForHumans()}}.
                        <span class="hidden md:inline-block">{{$thread->replies_count}} people have replied.</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                          <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z" />
                          <path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z" />
                        </svg>
                        {{-- {{$thread->replies_count}} --}}
                        <span v-text="repliesCount"></span>
                    </div>
                </div>
            </div>
            <div class="bg-gray-800 p-7 mt-3 mb-5 rounded-3xl text-white shadow-md">
                <div class="rounded-3xl">
                    <div class="mb-3">
                        <h3 class="font-semibold">
                            <a class="text-white text-base" href="{{$thread->creator->path()}}">{{$thread->creator->name}}</a>
                        </h3>
                        <div class="text-gray-400 text-xs">Posted {{$thread->created_at->diffForHumans()}}</div>
                    </div>
                    <div class="text-base font-semibold mb-3 bg-gray-700 p-3 rounded-lg">
                        {{ $thread->title }}
                    </div>
                    <p class="text-gray-200 text-sm">
                        {{$thread->body}}
                    </p>
                </div>
            </div>

            <v-replies :data="{{$thread->replies}}" @removed="repliesCount--" @added="repliesCount++"></v-replies>
        </div>
    </v-thread-show>
@endsection
