@extends('layouts.app')

@section('head')
    <script src="https://www.google.com/recaptcha/api.js?onload=vueRecaptchaApiLoaded&render=explicit" async defer>
    </script>
@endsection

@section('content')
    <v-thread-show :data="{{$thread}}" inline-template>
        <div class="w-full lg:w-4/5 mx-auto md:px-6">
            <a href="/threads" class="z-10 fixed bottom-7 left-7 btn-accent text-sm rounded-full w-16 h-16">
                <svg class="my-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            </a>
            <button v-if="!locked" @click="reply" class="fixed bottom-7 right-7 btn-accent text-sm rounded-full w-16 h-16">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
            </button>
            <div class="flex mt-7 justify-start items-end">
                <div class="w-8 h-8 ml-5 mr-3 border-t-4 border-l-4 border-gray-400 block align-bottom"></div>
                <div class="flex items-center justify-between w-full card text-black text-sm text-opacity-60 dark:text-white dark:text-opacity-50 px-4 py-2 rounded-2xl shadow-md">
                    <div class="flex-1 hidden md:inline-block">
                        <a href="{{$thread->creator->path()}}">{{ucfirst($thread->creator->name)}}</a> started this conversation {{$thread->created_at->diffForHumans()}}.
                        {{$thread->repliedPeople}} people have replied.
                    </div>
                    <div class="flex items-center ml-4">
                        <svg class="w-5 h-5 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                          <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z" />
                          <path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z" />
                        </svg>
                        <span v-text="repliesCount"></span>
                    </div>
                    <div class="flex items-center ml-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                          <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                          <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                        </svg>
                        <span>{{ $thread->visits() }}</span>
                    </div>
                    <div class="flex ml-4">
                        <v-subscribe :data="{{json_encode($thread->isSubscribed)}}"></v-subscribe>
                        <button v-if="authorize('isAdmin')" 
                            @click="lock" v-text="locked ? 'Unlock' : 'Lock'"
                            class="ml-4 text-xs rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-75 py-2 px-4"
                            :class="locked ? 'text-white bg-red-500' : 'text-red-500 bg-white border border-red-500'"
                        >
                        </button>
                    </div>
                </div>
            </div>
            <div class="flex relative items-start card p-5 mt-3 mb-5 rounded-2xl shadow-md">
                <img class="rounded-xl mr-3 w-16 h-16" src="https://gravatar.com/avatar/{{md5($thread->creator->email)}}?s=128" alt="{{$thread->creator->name}}'s avatar">
                <div class="rounded-3xl w-full">
                    <div class="mb-3">
                        <h3 class="font-semibold">
                            <a class="text-dark dark:text-white text-base" href="{{$thread->creator->path()}}">{{$thread->creator->name}}</a>
                        </h3>
                        <div class="text-black text-opacity-60 dark:text-white dark:text-opacity-50 text-xs">Posted {{$thread->created_at->diffForHumans()}}</div>
                    </div>
                    
                    <div v-if="isEdit">
                        <input type="text" v-model="title" class="text-input bg-gray-200 border-0 focus:ring-accent w-full mb-4">
                        <textarea name="body" rows="5" 
                            class="text-area bg-gray-200 border-0 focus:ring-accent w-full text-sm text-gray-700 mb-2"
                            v-model="body"
                        ></textarea>
                        <button
                            @click="update"
                            class="text-xs font-semibold bg-accent hover:bg-accent-darker border-accent text-white border rounded-xl inline-block px-2 py-2 md:px-3 mt-4"
                        >Update</button>
                        <button
                            @click="()=>{isEdit = false ,body = data.body, title = data.title}" 
                            class="text-xs font-semibold text-gray-500 hover:text-gray-600 rounded-xl inline-block px-2 py-2 md:px-3 mt-4 focus:outline-none ml-2"
                        >Cancel</button>
                    </div>
                    <div v-else>
                        <div class="text-base font-semibold mb-5 bg-gray-100 dark:bg-dark-primary shadow-sm p-3 rounded-lg" v-text="title"></div>
                        <p class="text-gray-700 leading-normal dark:text-white text-sm" v-text="body"></p>
                        <div v-if="authorize('owns', data)">
                            <button
                                @click="isEdit = true"
                                class="text-xs font-semibold bg-accent border-accent text-white border hover:bg-accent-darker rounded-xl inline-block px-2 py-2 md:px-3 mt-4"
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
