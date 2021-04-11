@extends('layouts.app')

@section('content')
    <div class="bg-gray-800 -m-4 mb-10">
        <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
            <div class="py-8">
                <div class="w-full mx-auto px-8">
                    <div class="md:flex justify-between items-start">
                        <div class="md:flex">
                            <div class="mb-0 md:mb-3 mr-3">
                                <svg class="mx-auto w-20 h-20 rounded-full text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="mb-3 md:mb-0 bg-gray-700 rounded-xl px-5 py-4 shadow-inner">
                                <div class="text-xl text-white">
                                    {{$profileUser->name}}
                                </div>
                                <div class="text-sm text-gray-200 font-light">
                                    Member Since {{$profileUser->created_at->diffForHumans()}}
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-between">
                            <div class="flex-1 h-52 bg-gray-700 rounded-xl p-7 text-center mr-2">
                                <div class="text-white font-semibold text-2xl mb-1">
                                    {{$profileUser->threads_count}}
                                    {{-- 28,040 --}}
                                </div>
                                <div class="text-gray-200 font-light">
                                    Total Discussions
                                </div>
                            </div>
                            <div class="flex-1 h-52 bg-gray-700 rounded-xl p-7 text-center">
                                <div class="text-white font-semibold text-2xl mb-1">
                                    {{$profileUser->replies_count}}
                                </div>
                                <div class="text-gray-200 font-light">
                                    Total Replies
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="w-full md:w-4/5 lg:w-3/5 mx-auto px-2 sm:px-6 lg:px-8">
        <div class="flex justify-center">
            <div class="text-xl text-gray-600 mb-8 px-5 py-1 border-b-2 border-indigo-400 inline-block mx-auto">
                Activity
            </div>
        </div>
        <div>
            @forelse ($records as $record => $activities)
                <div class="flex mb-5">
                    <div>
                        <div class="flex items-start mr-2">
                            @foreach (array_slice(explode('-', $record), 1,3) as $item)
                                <div class="bg-white shadow-lg px-2 mr-2 rounded-xl border-indigo-400 border-2">
                                    {{$item}}
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex-grow">
                        @foreach ($activities as $activity)
                            <div class="relative">
                                @include("profiles.activities.{$activity->type}")
                                <div class="flex flex-col h-full absolute -left-12 {{$loop->first ? 'top-10' : 'top-5'}} ">
                                    <svg class="timeline-icon z-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                    </svg>
                                    @if(!$loop->last)
                                        <div class="absolute top-2 left-4 border-dashed border-l-2 border-indigo-400 {{$loop->last ? 'h-0' : 'h-full'}}"></div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="text-center">
                    <div class="text-3xl text-gray-600 tracking-wide mb-3">Start Your first Discussions</div>

                    <a href="{{route('threads.create')}}">
                        <div class="btn-indigo inline-block">New Discussion</div>
                    </a>
                </div>
            @endforelse
        </div>
    </div>
@endsection