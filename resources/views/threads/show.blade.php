@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="level">
                            <span class="flex">
                                <a href="{{ route('profile',$thread->creator->name)}}">{{$thread->creator->name}}</a>  posted: {{$thread->title}}
                            </span>
                            @can ('update',$thread)
                            <form action="{{$thread->path()}}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-link">Delete Thread</button>
                            </form>
                            @endcan
                        </div>
                    </div>

                    <div class="card-body">
                        {{$thread->body}}
                    </div>
                </div>

                @foreach($replies as $reply)
                    @include('threads.reply')
                @endforeach

                {{$replies->links()}}

                @if(auth()->check())
                            <form action="{{$thread->path().'/replies'}}" style="padding-top: 20px">
                                @method('post')
                                @csrf
                                <div class="form-group">
                                    <textarea name="body" id="body" class="form-control" placeholder="Have Somethings to Say ?" rows="5"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Post</button>
                            </form>
                @else
                    <p class="text-center">Please <a href="{{route('login')}}">Sign In</a> To Participate in This Thread</p>
                @endif
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <p>
                            This thread was published {{$thread->created_at->diffForHumans()}} by <a href="{{route('profile',$thread->creator->name)}}">{{$thread->creator->name}}</a>
                            , and currently has  {{$thread->replies_count}} {{Str::plural('comment',$thread->replies_count)}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
