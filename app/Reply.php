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
}
