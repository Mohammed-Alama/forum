@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href="#">{{$thread->creator->name}}</a>  posted:
                        {{$thread->title}}</div>

                    <div class="card-body">
                        {{$thread->body}}
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-7">
                @foreach($thread->replies as $reply)
                    @include('threads.reply')
                @endforeach
            </div>
        </div>

        @if(auth()->check())
        <div class="row justify-content-center" style="padding-top: 40px">
            <div class="col-md-7">
                <form action="{{$thread->path().'/replies'}}">
                    @method('post')
                    @csrf
                    <div class="form-group">
                        <textarea name="body" id="body" class="form-control" placeholder="Have Somethings to Say ?" rows="5"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Post</button>
                </form>
            </div>
        </div>
          @else
            <p class="text-center">Please <a href="{{route('login')}}">Sign In</a> To Participate in This Thread</p>
         @endif

    </div>
@endsection