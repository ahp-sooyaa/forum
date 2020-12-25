<?php

function create($class, $attributes = [], $times = null)
{
    return modelName($class)::factory($times)->create($attributes);
}

function make($class, $attributes = [], $times = null)
{
    return modelName($class)::factory($times)->make($attributes);
}

function raw($class, $attributes = [], $times = null)
{
    return modelName($class)::factory($times)->raw($attributes);
}

function modelName($class)
{
    return "\\App\\Models\\{$class}";
}
