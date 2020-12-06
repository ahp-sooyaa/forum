<?php

function create($class, $attributes = [])
{
    return modelName($class)::factory()->create($attributes);
}

function make($class, $attributes = [])
{
    return modelName($class)::factory()->make($attributes);
}

function raw($class, $attributes = [])
{
    return modelName($class)::factory()->raw($attributes);
}

function modelName($class)
{
    return "\\App\\Models\\{$class}";
}
