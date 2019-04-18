<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    //
    protected $guarded = [];

    public function path()
    {
        return '/threads/'.$this->id;
    }
}
