<div id="reply-{{$reply->id}}" class="card">
<div class="card-header">
        <div class="level">
            <h5 class="flex">
                <a href="{{ route('profile',$reply->owner->name)}}">
                    {{$reply->owner->name}}
                </a> said {{$reply->created_at->diffForHumans()}}...
            </h5>

    <div>
        <form method="post" action="/replies/{{$reply->id}}/favorites">
            @csrf
            {{--TODO : insert heart font awesome in faovrite btn--}}
            <button type="submit" class="btn {{$reply->favorites()->count() == 0 ? 'btn-default' : 'btn-danger'}} {{$reply->isFavorited() ? 'disabled' : '' }} ">
                {{$reply->favorites_count}}  {{Str::plural('Favorite',$reply->favorites_count)}}
            </button>
        </form>
    </div>
        </div>
</div>
    <div class="card-body">
        {{$reply->body}}
    </div>
</div>