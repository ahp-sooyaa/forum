@extends('layouts.app')

@section('content')
    <div class="bg-gray-800 w-1/2 h-auto mx-auto mt-30 p-7 rounded-3xl mt-14 text-gray-300 shadow-lg">
        <h2 class="mb-3 text-3xl">Create Threads</h2>
        <form action="{{route('threads.store')}}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="channel_id" class="block text-sm font-medium text-gray-300">Channel</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                  <input type="text" name="channel_id" class="text-gray-700 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                </div>
            </div>

            <div class="mb-3">
                <label for="title" class="block text-sm font-medium text-gray-300">Title</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                  <input type="text" name="title" class="text-gray-700 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                </div>
            </div>

            <div class="mb-3">
                <label for="body" class="block font-medium text-gray-300">body</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                  <textarea name="body" rows="10" class="text-area"></textarea>
                </div>
            </div>

            <button class="btn-blue">
                Publish
            </button>
        </form>
    </div>
@endsection
