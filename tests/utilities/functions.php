<?php
/**
 * Created by PhpStorm.
 * User: renzhifan
 * Date: 2019-04-18
 * Time: 16:43
 */
function create($class,$attributes = [],$times = null)
{
    return factory($class,$times)->create($attributes);
}

function make($class,$attributes = [],$times = null)
{
    return factory($class,$times)->make($attributes);
}

function raw($class,$attributes = [],$times = null)
{
    return factory($class,$times)->raw($attributes);
}