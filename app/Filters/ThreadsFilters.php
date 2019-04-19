<?php
/**
 * Created by PhpStorm.
 * User: renzhifan
 * Date: 2019-04-19
 * Time: 10:29
 */

namespace App\Filters;
use Illuminate\Http\Request;
use App\User;
class ThreadsFilters extends Filters
{
    protected $filters = ['by','popularity'];

    /**
     * @param $username
     * @return mixed
     */
    protected function by($username)
    {
        $user = User::where('name', $username)->firstOrfail();

        return $this->builder->where('user_id', $user->id);
    }
    /**
     * @return mixed
     */
    public function popularity()
    {
        $this->builder->getQuery()->orders = [];
        return $this->builder->orderBy('replies_count','desc');
    }
}