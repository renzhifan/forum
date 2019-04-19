<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    //
    public function threads()
    {
        return $this->hasMany(Thread::class);
    }

   /* Route::get('threads/{channel}','ThreadController@index');
    {channel} 路由片段默认对应的是 id 字段，而我们需要对应的是 slug 字段。所以我们需要重写 getRouteKeyName() 方法*/
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
