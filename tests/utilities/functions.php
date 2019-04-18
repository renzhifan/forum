<?php
/**
 * Created by PhpStorm.
 * User: renzhifan
 * Date: 2019-04-18
 * Time: 16:43
 */
function create($class,$attributes = [])
{
    return factory($class)->create($attributes);
}

function make($class,$attributes = [])
{
    return factory($class)->make($attributes);
}

function raw($class,$attributes = [])
{
    return factory($class)->raw($attributes);
}