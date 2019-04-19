<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    //
    protected $guarded = [];

    public function scopeFilter($query,$filters)
    {
        return $filters->apply($query);
    }

    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";

    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id'); // 使用 user_id 字段进行模型关联
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function addReply($reply)
    {
        $this->replies()->create($reply);
    }
}
