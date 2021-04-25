@extends('layouts.app')

@section('content')
    <v-thread-show :data="{{$thread}}" inline-template>
        <div class="w-full lg:w-4/5 mx-auto md:px-6">
            <a href="/threads" class="z-10 fixed bottom-7 left-7 btn-indigo text-sm rounded-full w-16 h-16">
                <svg class="my-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            </a>
            <div class="flex mt-7 justify-start items-end">
                <div class="w-8 h-8 ml-5 mr-3 border-t-4 border-l-4 border-gray-300 block align-bottom"></div>
                <div class="flex items-center justify-between w-full bg-gray-800 px-6 py-4 rounded-2xl text-gray-300 shadow-md">
                    <div class="flex-1 text-sm hidden md:inline-block">
                        <a href="{{$thread->creator->path()}}">{{ucfirst($thread->creator->name)}}</a> started this conversation {{$thread->created_at->diffForHumans()}}.
                        {{$thread->replies_count}} people have replied.
                    </div>
                    <div class="flex items-center ml-4">
                        <svg class="w-5 h-5 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                          <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z" />
                          <path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z" />
                        </svg>
                        <span v-text="repliesCount"></span>
                    </div>
                    <div class="flex ml-4">
                        <v-subscribe :data="{{json_encode($thread->isSubscribed)}}"></v-subscribe>
                        <button v-if="authorize('isAdmin')" 
                            @click="lock" v-text="locked ? 'Unlock' : 'Lock'"
                            class="ml-4 text-xs rounded-xl focus:outline-none focus:ring-0 py-2 px-4"
                            :class="locked ? 'text-white bg-red-500' : 'text-red-500 bg-white border border-red-500'"
                        >
                        </button>
                    </div>
                </div>
            </div>
            <div class="flex relative items-start bg-gray-800 p-5 mt-3 mb-5 rounded-2xl text-white shadow-md">
                <img class="rounded-xl mr-3 w-16 h-16" src="https://gravatar.com/avatar/{{md5($thread->creator->email)}}?s=60" alt="{{$thread->creator->name}}'s avatar">
                <div class="rounded-3xl w-full">
                    <div class="mb-3">
                        <h3 class="font-semibold">
                            <a class="text-white text-base" href="{{$thread->creator->path()}}">{{$thread->creator->name}}</a>
                        </h3>
                        <div class="text-gray-400 text-xs">Posted {{$thread->created_at->diffForHumans()}}</div>
                    </div>
                    
                    <div v-if="isEdit">
                        <input type="text" v-model="title" class="text-input w-full mb-4">
                        <textarea name="body" rows="5" 
                            class="text-area w-full text-sm text-gray-700 mb-2"
                            v-model="body"
                        ></textarea>
                        <button
                            @click="update"
                            class="text-xs font-semibold bg-gray-800 border-gray-500 text-gray-400 hover:border-gray-400 border rounded-xl inline-block px-2 py-2 md:px-3 mt-4"
                        >Update</button>
                        <button
                            @click="()=>{isEdit = false ,body= data.body, title= data.title}"
                            class="text-xs font-semibold bg-red-800 border-red-500 text-red-400 hover:border-red-400 border rounded-xl inline-block px-2 py-2 md:px-3 mt-4 focus:outline-none ml-3"
                        >Cancel</button>
                    </div>
                    <div v-else>
                        <div class="text-base font-semibold mb-5 bg-gray-700 p-3 rounded-lg" v-text="title"></div>
                        <p class="text-gray-200 text-sm" v-text="body"></p>
                        <div v-if="authorize('owns', data)">
                            <button
                                @click="isEdit = true"
                                class="text-xs font-semibold bg-gray-800 border-gray-500 text-gray-400 hover:border-gray-400 border rounded-xl inline-block px-2 py-2 md:px-3 mt-4"
                            >Edit</button>
                        </div>
                    </div>
                </div>
                <svg v-if="locked" xmlns="http://www.w3.org/2000/svg" class="absolute right-6 text-red-500 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>

            <v-replies @deleted="repliesCount--" @created="repliesCount++"></v-replies>

            {{-- <v-paginator></v-paginator> --}}
        </div>
    </v-thread-show>
@endsection
