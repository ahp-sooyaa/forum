<?php

namespace App\Filters;

use App\Models\User;

class ThreadFilter extends Filters
{
    protected $filters = ['by', 'popular'];

    /**
     * Thread Filtered by username
     *
     * @param string $username
     * @return mixed
     */
    public function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();

        return $this->builder->where('user_id', $user->id);
    }

    public function popular()
    {
        $this->builder->getQuery()->orders = [];

        return $this->builder->orderBy('replies_count', 'desc');
    }
}
