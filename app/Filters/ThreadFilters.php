<?php


namespace App\Filters;


use App\User;


class ThreadFilters extends Filters
{

    protected $filters = ['by','popular'];
    /**
     * Filter the query by given username.
     * @param string $username
     * @return mixed
     */
    protected function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();
        return $this->builder->where('user_id', $user->id);
    }

    /**
     * Filter the query according to most popular threads.
     * @return mixed
     */

    protected function popular()
    {
        //here we will remove order we have made in index method query
        $this->builder->getQuery()->orders = [];
        return $this->builder->orderBy('replies_count','desc');

    }
}