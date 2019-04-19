<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    //
    protected $guarded = [];

    //我们不仅想在 show 页面显示，而在 index 页面也进行显示。我们利用 Laravel 全局作用域 来实现。
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('replyCount',function ($builder){
            $builder->withCount('replies');
        });
    }
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
        return $this->hasMany(Reply::class)
            ->withCount('favorites')
            ->with('owner');
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
