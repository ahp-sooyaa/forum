@extends('layouts.app')

@section('head')
    <script src="https://www.google.com/recaptcha/api.js"></script>

    <script>
      function onSubmit(token) {
        document.getElementById("thread-create").submit();
      }
    </script>
@endsection

@section('content')
    <div class="bg-gray-800 w-full md:w-2/3 lg:w-1/2 h-auto mx-auto mt-30 p-7 rounded-3xl mt-14 text-gray-300 shadow-lg">
        <a href="/threads" class="z-10 fixed bottom-7 left-7 btn-indigo text-sm rounded-full w-16 h-16">
            <svg class="my-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
            </svg>
        </a>
        {{-- <h2 class="mb-3 text-3xl">New Threads</h2> --}}
        <form id="thread-create" action="{{route('threads.store')}}" method="POST">
            @csrf
            @honeypot
            
            <div class="mb-3">
                <label for="channel_id" class="block text-sm font-medium text-gray-300">Channel</label>
                <select name="channel_id" class="text-input" required>
                    <option value="">Choose Channel...</option>
                    <!-- the following $channels is sharing from app service provider -->
                    @foreach ($channels as $channel)
                        <option value="{{$channel->id}}" {{old('channel_id') == $channel->id ? 'selected' : ''}}>
                            {{$channel->name}}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="title" class="block text-sm font-medium text-gray-300">Title</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                  <input type="text" name="title" class="text-input @error('email') is-invalid @enderror" value="{{old('title')}}" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="body" class="block font-medium text-gray-300">body</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                  <textarea name="body" rows="10" class="text-area" required>{{old('body')}}</textarea>
                </div>
            </div>

            <button class="g-recaptcha btn-indigo" 
                data-sitekey="6LcEHLYaAAAAAGLAYvJ_TeGR3y0FjT0AbLjGIHvj" 
                data-callback='onSubmit' 
                data-action='submit'
            >Publish</button>

            @if ($errors)
                @foreach($errors->all() as $error)
                    <div class="text-red-500">{{$error}}</div>
                @endforeach
            @endif
        </form>
    </div>
@endsection
