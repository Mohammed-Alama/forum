<?php

namespace App\Http\Controllers;


use App\Channel;
use App\Filters\ThreadFilters;
use App\Thread;
use Illuminate\Http\Request;
use Illuminate\Http\Response;



/**
 * Class ThreadsController
 * @package App\Http\Controllers
 */
class ThreadsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['show','index']);
    }

    /**
     * Display a listing of the resource.
     * @param Channel $channel
     * @param ThreadFilters $filters
     * @return Response
     */
    public function index(Channel $channel,ThreadFilters $filters)
    {
        $threads = $this->getThreads($channel, $filters);

        if (request()->wantsJson()){
            return $threads;
        }
        return view('threads.index',compact('threads'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     * @throws
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title'=>'required',
            'body'=>'required',
            'channel_id'=>'required | exists:channels,id'
        ]);
       $thread = Thread::create([
            'user_id'=>auth()->id(),
            'channel_id'=>request('channel_id'),
            'title'=>request('title'),
            'body'=>request('body')
        ]);
       return redirect($thread->path())
           ->with('flash','Your thread has been publish');

    }

    /**
     * Display the specified resource.
     *
     * @param $channel_id
     * @param  Thread  $thread
     * @return Response
     */
    public function show($channel_id,Thread $thread)
    {
        return view('threads.show',['thread'=>$thread,'replies'=> $thread->replies()->paginate(20)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Thread  $thread
     * @return Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Thread  $thread
     * @return Response
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Thread  $thread
     * @return mixed
     * @throws
     */
    public function destroy($channel ,Thread $thread)
    {
//        if ($thread->user_id != auth()->id()){
//            abort(403,'You do not have permission to do this');
//        }
        $this->authorize('update',$thread);

        $thread->delete();

        if (request()->wantsJson()){
            return response([],204);
        }
        return redirect('/threads');

    }

    /**
     * @param Channel $channel
     * @param ThreadFilters $filters
     * @return mixed
     */
    protected function getThreads(Channel $channel, ThreadFilters $filters)
    {
        $threads = Thread::with('channel')->latest()->filter($filters);
        if ($channel->exists) {
            $threads->where('channel_id', $channel->id);
        }

//        dd($threads->toSql());
        return  $threads->get();


    }

}
