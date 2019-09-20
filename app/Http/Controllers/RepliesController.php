<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    /**
     * Create a New RepliesController instance
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Persist a new Reply
     *
     * @param Request $request
     * @param integer $channel_id
     * @param Thread $thread
     * @return RedirectResponse
     * @throws
     */
    public function store(Request $request,$channel_id, Thread $thread)
    {

        $this->validate($request,['body' => 'required']);
        $thread->addReply([
            'body' =>request('body'),
            'user_id' => auth()->id()
        ]);

        return back();
    }
}
