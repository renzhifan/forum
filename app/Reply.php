<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    //
    protected $guarded = [];

    public function owner()
    {
        return $this->belongsTo(User::class,'user_id');  // 使用 user_id 字段进行模型关联
    }
    //多态关联允许一个模型在单个关联上属于多个其他模型 。
    public function favorites()
    {
        return $this->morphMany(Favorite::class,'favorited');
    }
    public function favorite()
    {
        $attributes = ['user_id' => auth()->id()];

        if( ! $this->favorites()->where($attributes)->exists()){
            return $this->favorites()->create($attributes);
        }
    }
}
